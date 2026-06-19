<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings for the admin dashboard.
     */
    public function index()
    {
        $bookings = DB::table('consultation_bookings')
            ->join('mentors', 'consultation_bookings.mentor_id', '=', 'mentors.id')
            ->join('users', 'consultation_bookings.user_id', '=', 'users.id')
            ->select(
                'consultation_bookings.*',
                'mentors.name as mentor_name',
                'users.name as student_name'
            )
            ->orderBy('consultation_bookings.created_at', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Display a specific booking detail for the admin.
     */
    public function show($id)
    {
        $booking = DB::table('consultation_bookings')
            ->join('mentors', 'consultation_bookings.mentor_id', '=', 'mentors.id')
            ->join('users', 'consultation_bookings.user_id', '=', 'users.id')
            ->select(
                'consultation_bookings.*',
                'mentors.name as mentor_name',
                'users.name as student_name',
                'users.email as student_email'
            )
            ->where('consultation_bookings.id', $id)
            ->first();

        if (!$booking) {
            abort(404, 'Booking not found.');
        }

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update the status of a booking (Admin Action).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rescheduled,Rejected',
        ]);

        $booking = DB::table('consultation_bookings')->where('id', $id)->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        // Enforce the permanent state lock condition
        if ($booking->status !== 'Pending') {
            return redirect()->back()->with('error', 'This decision is permanent and cannot be modified.');
        }

        DB::table('consultation_bookings')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking status updated to ' . $request->status);
    }

    /**
     * Delete/Dismiss a booking record completely (Admin Action).
     */
    public function destroy($id)
    {
        $deleted = DB::table('consultation_bookings')->where('id', $id)->delete();

        if (!$deleted) {
            return redirect()->back()->with('error', 'Failed to delete booking or booking not found.');
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking record deleted successfully.');
    }

    /**
     * Display the student's personal bookings dashboard list.
     */
    public function studentIndex()
    {
        $bookings = DB::table('consultation_bookings')
            ->join('mentors', 'consultation_bookings.mentor_id', '=', 'mentors.id')
            ->select(
                'consultation_bookings.*',
                'mentors.name as mentor_name',
                'mentors.platform',
                'mentors.specialty'
            )
            ->where('consultation_bookings.user_id', Auth::id())
            ->orderBy('consultation_bookings.created_at', 'desc')
            ->get();

        return view('student.bookings.index', compact('bookings'));
    }

    /**
     * Show the creation form for a student to schedule a session.
     */
    public function studentCreate()
    {
        $mentors = DB::table('mentors')->get();
        return view('student.bookings.create', compact('mentors'));
    }

    /**
     * Store a newly created booking request in storage from a student.
     */
    public function studentStore(Request $request)
    {
        // Fixed: Added existence validation for mentor_id and rigid enum safety for the booking slot
        $request->validate([
            'mentor_id' => 'required|exists:mentors,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_slot' => 'required|string|in:06:30 - 08:30,08:30 - 10:30,10:30 - 12:30,12:30 - 14:30,14:30 - 16:30',
            'notes' => 'nullable|string|max:1000',
        ]);

        $slotParts = explode(' - ', $request->booking_slot);
        $startTimeString = count($slotParts) > 0 ? trim($slotParts[0]) : '08:00';
        $bookingTime = date('H:i:s', strtotime($startTimeString));

        DB::table('consultation_bookings')->insert([
            'user_id' => Auth::id(),
            'mentor_id' => $request->mentor_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $bookingTime,
            'notes' => $request->notes,
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('student.bookings.index')->with('success', 'Consultation session booked successfully!');
    }
}