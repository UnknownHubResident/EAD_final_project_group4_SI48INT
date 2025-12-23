<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Major;
use App\Models\Scholarship;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Status Checks
        if ($user->is_rejected) {
            return view('rejected-approval');
        } 

        if (!$user->is_approved) {
            if ($user->role === 'student') {
                return view('auth.deactivated');
            }
            if ($user->role === 'scholar_provider') {
                if ($user->created_at->eq($user->updated_at)) {
                    return view('pending-approval'); 
                }
                return view('auth.deactivated'); 
            }
        }

        // 2. Student Dashboard Logic
        if ($user->role === 'student') {
            $majors = Major::all();
            $scholarships = Scholarship::with('majors')->where('is_active', true)->latest()->paginate(9);
            
            // MATCHING YOUR PICTURE: resources/views/dashboard/student.blade.php
            return view('dashboard.student', compact('majors', 'scholarships'));
        }

        if ($user->role === 'scholar_provider') {
            return view('dashboard.scholar_provider'); 
        }

        if ($user->role === 'admin') {
            return view('dashboard.admin'); 
        }

        abort(403);
    }
}