<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showPendingProviders()
        {
            $pendingUsers = User::where('is_approved', false)
                            ->where('role', 'student')
                            ->get();

        // 2. Pass the list to a new view
        return view('admin.pending_list', compact('pendingUsers'));
    }
        
    

    public function approveProvider(User $user)
    {
       
        

      
        $user->update([
            'role' => 'scholar_provider', // FINAL ROLE: Set the role to 'scholar_provider'
            'is_approved' => true,         // STATUS: Set the approval status to active
        ]);

        return back()->with('success', $user->name . ' is now an approved Scholar Provider.');
    }
}
