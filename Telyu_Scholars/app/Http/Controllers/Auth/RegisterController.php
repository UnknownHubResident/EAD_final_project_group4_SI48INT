<?php

namespace App\Http\Controllers;

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

        if ($intendedRole === 'scholar_provider') {
            $assignedRole = 'student';    
            $message = 'Registration successful! Your request to be a Provider is pending Admin approval.';
        } 
        
        else {
            
            $assignedRole = 'student';
            $isApproved = true;            
            $message = 'Registration is successful!';
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => '$assignedRole',
            'is_approved' => $isApproved,
            
        ]);

        return redirect('/login')->with('success', $message);
    }

}




