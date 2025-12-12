<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashBoardController extends Controller
{
    
    public function index(Request $request)
    {

        $user = Auth::user();

        // 1. Check for REJECTED/SUSPENDED status (Highest Priority)
        if ($user->is_rejected) {
            return view('rejected-approval');
        } 

        // 2. Check for PENDING status (Not approved AND not rejected)
        if (!$user->is_approved) {
            return view('pending-approval');
        }

        // 3. Routing for APPROVED users
        if ($user->role === 'admin') {
            return view('dashboard.admin');
        } 
        
        if ($user->role === 'scholar_provider') {
            return view('dashboard.scholar_provider');
        }

        return view('dashboard.student');
    }
}