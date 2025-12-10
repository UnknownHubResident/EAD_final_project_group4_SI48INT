<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashBoardController extends Controller
{
    

    public function index()
    {

        $user = Auth::user();

        if (!$user->is_approved) {
            return view('pending-approval');
    }

    if ($user->role === 'admin') {
            return view('dashboard.admin');
        } 
        
        if ($user->role === 'scholar_provider') {
            return view('dashboard.scholar_provider');
        }

        return view('dashboard.student');
}

}
