@extends('layouts.student')

@section('content')
<div class="bg-gray-100 min-h-screen py-6">
    <div class="max-w-5xl mx-auto px-4">
        
        {{-- Session Flash Alert Toast Handling --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2.5 rounded text-xs font-medium mb-4 shadow-xs">
                {{ session('success') }}
            </div>
        @endif

        {{-- Top Navigation Deck Row --}}
        <div class="flex justify-between items-center mb-4">
            <div>
                <span class="text-xs font-mono uppercase text-gray-400 tracking-wider">STUDENT PANEL</span>
                <h1 class="text-2xl font-bold text-gray-800">My consultation dashboard</h1>
            </div>
            <a 
                href="{{ route('student.bookings.create') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-1.5 px-4 rounded shadow-xs transition"
            >
                + Schedule Consultation
            </a>
        </div>

        {{-- Clean Booking Data Log Table Element --}}
        <div class="bg-white border border-gray-200 rounded-md shadow-xs overflow-hidden">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 font-bold border-b border-gray-300">
                        <th class="p-3">counselor name</th>
                        <th class="p-3">booking date</th>
                        <th class="p-3">booking time</th>
                        <th class="p-3 text-center">status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-semibold text-gray-900">{{ $booking->mentor_name }}</td>
                            <td class="p-3">{{ date('M d, Y', strtotime($booking->booking_date)) }}</td>
                            <td class="p-3 text-gray-500">
                                {{ isset($booking->booking_time) ? date('g:i A', strtotime($booking->booking_time)) : 'N/A' }}
                            </td>
                            <td class="p-3 text-center">
                                @php
                                    $status = ucfirst(trim($booking->status));
                                    $badgeClass = match($status) {
                                        'Approved' => 'bg-green-500 text-white',
                                        'Rejected' => 'bg-red-500 text-white',
                                        'Rescheduled' => 'bg-orange-400 text-white',
                                        default => 'bg-yellow-400 text-black',
                                    };
                                @endphp
                                <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded shadow-xs {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-400 italic">
                                You have not registered any consultation bookings yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection