<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'student_number' => 'required_if:role,student|string',
            'study_major' => 'required_if:role,student|string',
            'degree_rank' => 'required_if:role,student|string',
            'year_batch' => 'required_if:role,student|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => $request->role === 'student' ? true : false,
            'student_number' => $request->student_number,
    'study_major'    => $request->study_major,
    'degree_rank'    => $request->degree_rank,
    'year_batch'     => $request->year_batch, // Auto-approve students, providers wait
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
       $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

   
    if ($user->role === 'scholar_provider' && !$user->is_approved) {

        $reason = $user->rejection_reason ? " Reason: " . $user->rejection_reason : "";
    return response()->json([
        'message' => 'Your account is pending admin approval.' . $reason // Variable added!
    ], 403);
    }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // 1. List all users (Admin Only)
public function indexUsers()
{
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $users = User::all();
    return response()->json([
        'success' => true,
        'data' => $users
    ]);
}

// 2. Toggle User Active Status (Admin Only)
public function toggleUserStatus(User $user)
{
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    // Toggle the boolean (if 1 becomes 0, if 0 becomes 1)
    $user->update(['is_active' => !$user->is_active]);

    $status = $user->is_active ? 'activated' : 'deactivated';

    return response()->json([
        'success' => true,
        'message' => "User {$user->name} has been {$status}."
    ]);
}


public function destroyUser(User $user)
{
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $user->delete();

    return response()->json([
        'success' => true,
        'message' => 'User deleted successfully.'
    ]);
}

    public function approveProvider(User $user)
{
    // Ensure only an admin can do this
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $user->update(['is_approved' => true]);

    return response()->json([
        'success' => true,
        'message' => 'Provider ' . $user->name . ' has been approved.'
    ]);
}

public function rejectProvider(Request $request, User $user)
{
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $request->validate([
        'reason' => 'required|string'
    ]);

 
    $user->update([
        'is_approved' => false,
        'rejection_reason' => $request->reason 
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Provider rejected. Reason: ' . $request->reason
    ]);
}

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}