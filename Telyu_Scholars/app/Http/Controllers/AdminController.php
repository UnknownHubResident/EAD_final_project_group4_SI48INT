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

    public function manageUsers()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.users')->with('success', "User details for {$user->name} updated successfully!");
    }

    public function deleteUser(User $user)
    {

        if ($user->role === 'admin'){
            return back()->with('error', 'how desperate are you, that your job is more valuable than your close friends?');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', "user '{$user->name}' deleted successfully!");
    }

    public function toggleActiveStatus(User $user)
    {

        if ($user->role === 'admin')
        {
            return back()->with('error', 'whats the point of having friend, when they tried to sabotage you!!!');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User '{$user->name}' account {$status} successfully");
    }
}
