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
                            ->where('is_rejected', false)
                            ->where('role', 'scholar_provider')
                            ->get();

        return view('admin.pending_list', compact('pendingUsers'));
    }
        
    
    public function approveProvider(User $user)
    {
        $user->update([
            'role' => 'scholar_provider', 
            'is_approved' => true,  
            'is_rejected' => false, 
        ]);

        return back()->with('success', $user->name . ' is now an approved Scholar Provider.');
    }
    
   
    public function showRejectForm(User $user)
    {
        
        if ($user->role !== 'scholar_provider' || $user->is_approved || $user->is_rejected) {
            return redirect()->route('admin.pending')
                 ->with('error', 'User cannot be rejected: Already approved or rejected.');
        }

        return view('admin.reject_form', compact('user'));
    }

   
    public function finalizeReject(Request $request, User $user)
    {
       
        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);
        
        
        $user->update([
            'is_approved' => false, 
            'rejection_reason' => $validated['rejection_reason'] ?? null, 
        ]);

        return redirect()->route('admin.pending')->with('success', $user->name . ' has been suspended and flagged as rejected.');
    }

  
    public function unrejectProvider(User $user)
    {
       
        if (!$user->is_rejected) {
            return back()->with('error', 'User is not currently rejected/suspended.');
        }

       
        $updateData = [
            'is_approved' => true,      
            'is_rejected' => false,      
            'rejection_reason' => null,  
        ];

        if ($user->role === 'scholar_provider') {
            $updateData['role'] = 'scholar_provider';
        }

        $user->update($updateData);

        return back()->with('success', $user->name . ' has had their suspension lifted and is now approved.');
    }
}