<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a list of providers waiting for approval.
     */
    public function showPendingProviders()
    {
        // MERGED LOGIC: We filter by 'scholar_provider' role and ensure they aren't approved/rejected yet.
        $pendingUsers = User::where('is_approved', false)
                            ->where('is_rejected', false)
                            ->where('role', 'scholar_provider')
                            ->get();

        return view('admin.pending_list', compact('pendingUsers'));
    }

    /**
     * Approve a provider.
     */
    public function approveProvider(User $user)
    {
        // MERGED LOGIC: Combines the status flags and the role update from both branches.
        $user->update([
            'role' => 'scholar_provider', 
            'is_approved' => true,   
            'is_rejected' => false, 
        ]);

        return back()->with('success', $user->name . ' is now an approved Scholar Provider.');
    }

    /**
     * Show the form to provide a reason for rejection.
     */
    public function showRejectForm(User $user)
    {
        // Safeguard: Ensure we don't try to reject someone already handled.
        if ($user->role !== 'scholar_provider' || $user->is_approved || $user->is_rejected) {
            return redirect()->route('admin.pending')
                 ->with('error', 'User cannot be rejected: Already approved or rejected.');
        }

        return view('admin.reject_form', compact('user'));
    }

    /**
     * Save the rejection reason and update status.
     */
    public function finalizeReject(Request $request, User $user)
    {
        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);
        
        $user->update([
            'is_approved' => false, 
            'is_rejected' => true, // Added this flag to match your original intent
            'rejection_reason' => $validated['rejection_reason'] ?? null, 
        ]);

        return redirect()->route('admin.pending')->with('success', $user->name . ' has been suspended and flagged as rejected.');
    }

    /**
     * Restore a rejected provider to active status.
     */
    public function unrejectProvider(User $user)
    {
        if (!$user->is_rejected) {
            return back()->with('error', 'User is not currently rejected/suspended.');
        }

        $user->update([
            'is_approved' => true,      
            'is_rejected' => false,      
            'rejection_reason' => null,  
            'role' => 'scholar_provider'
        ]);

        return back()->with('success', $user->name . ' has had their suspension lifted and is now approved.');
    }
}