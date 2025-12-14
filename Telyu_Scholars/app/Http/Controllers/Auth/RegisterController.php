<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    
    public function ShowRegisFrom()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'intended_role' => ['required', Rule::in(['student', 'scholar_provider'])],
        ]);

        $intendedRole = $validated['intended_role'];

        // Default values: everyone starts as a student
        $assignedRole = 'student'; 
        
        // --- LOGIC TO DETERMINE APPROVAL STATUS ---
        if ($intendedRole === 'scholar_provider') {
            // A Provider is NOT approved yet, hence false.
            $isApproved = false; 
            $message = 'Registration successful! Your request to be a Provider is pending Admin approval.';
        } 
        
        else {
            // A Student is automatically approved, hence true.
            $isApproved = true;
            $message = 'Registration is successful!';
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            // FIX 2: Removed single quotes to use the variable value
            'role' => $assignedRole, 
            // FIX 1: This variable is now guaranteed to be set in the logic above
            'is_approved' => $isApproved, 
        ]);

        return redirect('/login')->with('success', $message);
    }
}