<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'scholar_provider') {
             return redirect()->route('admin.users.index')
                 ->with('error', 'Details view is only applicable for Providers.');
        }

        $user = $user->load('scholarships');
        return view('admin.users.show', compact('user'));
    } 

    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot change the status of an Admin account.');
        }

        // Keep your original safeguard
        if ($user->role === 'scholar_provider') {
            return back()->with('error', 'Use the dedicated approval/rejection pages for Scholar Providers.');
        }

        $user->is_approved = !$user->is_approved;

        if ($user->is_approved) {
            $user->is_rejected = false;
            $user->rejection_reason = null; 
        }
        
        $user->save();

        $status = $user->is_approved ? 'Activated' : 'Deactivated';
        return back()->with('success', "User '{$user->name}' has been successfully {$status}.");
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete the main Admin account.');
        }
        $user->delete();
        return back()->with('success', "User '{$user->name}' has been permanently deleted.");
    }
}