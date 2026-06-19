@extends('layouts.admin')

@section('content')
<div class="bg-gray-100 min-h-screen p-6">
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 tracking-wide">consultation session booking management</h2>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded-r text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded-r text-sm">
                {{ session('error') }}
            </div>
        @endif

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-300 text-gray-700 font-bold">
                    <th class="p-3">student name</th>
                    <th class="p-3">booking date</th>
                    <th class="p-3">time slot</th>
                    <th class="p-3">status</th>
                    <th class="p-3 text-center">actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr class="border-b border-gray-200 hover:bg-gray-50 text-gray-800">
                    {{-- Fixed: Directly reading the flat string property from the join query --}}
                    <td class="p-3 font-semibold">{{ $booking->student_name }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                    <td class="p-3">
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB
                    </td>
                    <td class="p-3">
                        @if($booking->status === 'Pending')
                            <span class="px-3 py-1 text-xs font-bold bg-yellow-400 text-yellow-900 rounded-full uppercase">pending info</span>
                        @elseif($booking->status === 'Approved')
                            <span class="px-3 py-1 text-xs font-bold bg-green-500 text-white rounded-full uppercase">approved</span>
                        @elseif($booking->status === 'Rescheduled')
                            <span class="px-3 py-1 text-xs font-bold bg-orange-400 text-white rounded-full uppercase">rescheduled</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold bg-red-500 text-white rounded-full uppercase">rejected</span>
                        @endif
                    </td>
                    <td class="p-3 text-center flex justify-center items-center gap-2">
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-4 py-1.5 rounded transition shadow-sm">
                            process detail
                        </a>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this booking record?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded transition shadow-sm">
                                delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">No student consultation sessions found in database records.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection