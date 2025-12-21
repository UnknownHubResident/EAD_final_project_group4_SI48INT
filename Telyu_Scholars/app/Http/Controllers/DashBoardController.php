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

    // 1. PRIORITY: If they are formally REJECTED, show the red screen
    if ($user->is_rejected) {
        return view('rejected-approval');
    } 

    // 2. If the user is NOT approved
    if (!$user->is_approved) {
        // Students always go to Deactivated
        if ($user->role === 'student') {
            return view('auth.deactivated');
        }

        // Provider Logic: Distinguish between "New" and "Deactivated"
        if ($user->role === 'scholar_provider') {
            /* If the user was created and updated at the exact same time,
               it means an Admin has NEVER touched/approved this account yet.
            */
            if ($user->created_at->eq($user->updated_at)) {
                return view('pending-approval'); 
            }
            
            // If updated_at is different, it means they were once approved 
            // but now the Admin has toggled them to 'Deactivated'
            return view('auth.deactivated'); 
        }
    }

    // 3. Normal logic for Active Users...
    if ($user->role === 'student') {
        $majors = Major::all();
        $scholarships = Scholarship::with('majors')->where('is_active', true)->latest()->paginate(9);
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