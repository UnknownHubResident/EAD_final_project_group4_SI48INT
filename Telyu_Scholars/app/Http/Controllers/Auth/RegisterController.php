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
            'student_number' => ['required_if:intended_role,student','nullable', 'string','min:12','max:12', 'unique:users,student_number'],
            'study_major' => ['required_if:intended_role,student', 'nullable', 'string', 'max:255'],
            'year_batch' => ['required_if:intended_role,student', 'nullable', 'string', 'digits:4' ],
            'degree_rank' => ['required_if:intended_role,student', 'nullable', Rule::in(['Bachelor', 'Master', 'PhD'])],
        ]);

        $intendedRole = $validated['intended_role'];

        // Default values: everyone starts as a student
        $assignedRole = $intendedRole; 
        
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

            'student_number' => $validated['student_number'] ?? null,
            'study_major' => $validated['study_major'] ?? null,
            'degree_rank' => $validated['degree_rank'] ?? null,
            'year_batch' => $validated['year_batch'] ?? null,
            
            'role' => $assignedRole, 
            'is_approved' => $isApproved, 
            'is_rejected' => false,
        ]);

        return redirect('/login')->with('success', $message);
    }
}