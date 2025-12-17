<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Major;        
use App\Models\Scholarship;  

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Guard Checks (Your Logic)
        if ($user->is_rejected) {
            return view('rejected-approval');
        } 

        if ($user->role === 'scholar_provider' && !$user->is_approved) {
            return view('pending-approval');
        }

        // 2. Student Logic (Merged from Main)
        if ($user->role === 'student') {
            $majors = Major::all();
            $scholarships = Scholarship::with('majors')
                ->where('is_active', true)
                ->latest()
                ->paginate(9);

            return view('dashboard.student', compact('majors', 'scholarships'));
        }

        // 3. Provider Logic
        if ($user->role === 'scholar_provider') {
            return view('dashboard.scholar_provider'); 
        }

        // 4. Admin Logic
        if ($user->role === 'admin') {
            return view('dashboard.admin'); 
        }

        abort(403, 'Unauthorized action.');
    }
}