@extends('layouts.admin')

@section('content')
<div class="bg-gray-100 min-h-screen p-6">
    <div class="bg-white rounded-lg shadow max-w-4xl mx-auto border border-gray-200 overflow-hidden">
        
        @if($booking->status === 'Pending')
            <div class="bg-yellow-400 text-yellow-950 p-4 font-bold text-center tracking-wide text-sm">
                ⚠️ This request token application file remains under pending administrative verification status.
            </div>
        @elseif($booking->status === 'Approved')
            <div class="bg-green-500 text-white p-4 font-bold text-center tracking-wide text-sm">
                ✅ request token status approved: verification completed successfully.
            </div>
        @elseif($booking->status === 'Rescheduled')
            <div class="bg-orange-400 text-white p-4 font-bold text-center tracking-wide text-sm">
                ⏳ request token has been marked for active rescheduling window adjustment.
            </div>
        @else
            <div class="bg-red-600 text-white p-4 font-bold text-center tracking-wide text-sm">
                ❌ application submission rejected due to failed administrative profile checks.
            </div>
        @endif

        <div class="p-6">
            <a href="{{ route('admin.bookings.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-semibold flex items-center mb-6">
                ← back to session management
            </a>

            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h2 class="text-2xl font-bold text-gray-800">Process Consultation Request</h2>
                
                @if($booking->status === 'Pending')
                    <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <button type="submit" name="status" value="Approved" class="bg-green-500 hover:bg-green-600 text-white font-bold text-xs px-4 py-2 rounded shadow transition">approve</button>
                        <button type="submit" name="status" value="Rescheduled" class="bg-orange-400 hover:bg-orange-500 text-white font-bold text-xs px-4 py-2 rounded shadow transition">reschedule</button>
                        <button type="submit" name="status" value="Rejected" class="bg-red-500 hover:bg-red-600 text-white font-bold text-xs px-4 py-2 rounded shadow transition">reject</button>
                    </form>
                @else
                    <span class="text-xs bg-gray-200 text-gray-600 px-3 py-2 rounded font-mono font-bold uppercase">
                        🔒 Status Decision Permanent
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-md border border-gray-200 mb-6">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">student information</h3>
                    <p class="text-base font-bold text-gray-800 mt-1">{{ $booking->student_name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Email: {{ $booking->student_email }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">assigned counselor</h3>
                    <p class="text-base font-bold text-gray-800 mt-1">{{ $booking->mentor_name }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">requested date slot</h3>
                    <p class="text-sm font-semibold text-gray-700 mt-1">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y') }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">requested timeframe</h3>
                    <p class="text-sm font-semibold text-gray-700 mt-1">
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB
                    </p>
                </div>
            </div>

            <div class="bg-white border border-gray-300 rounded p-4 shadow-sm">
                <h3 class="text-sm font-bold text-gray-700 mb-2">Student Consultation Notes / Reason:</h3>
                <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-3 rounded border border-gray-100">
                    {{ $booking->notes ?? 'No additional guidance context was attached to this request transmission.' }}
                </p>
            </div>

        </div>
    </div>
</div>
@endsection