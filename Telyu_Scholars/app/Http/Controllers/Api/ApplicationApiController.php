<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicationApiController extends Controller
{
    // 1. Student applies for a scholarship
    public function apply(Request $request, Scholarship $scholarship)
    {
        $user = Auth::guard('sanctum')->user();

        // Security: Only students can apply
        if ($user->role !== 'student') {
            return response()->json(['message' => 'Only students can apply for scholarships.'], 403);
        }

        // Check if already applied
        $exists = Application::where('user_id', $user->id)
                            ->where('scholarship_id', $scholarship->id)
                            ->exists();
        if ($exists) {
            return response()->json(['message' => 'You have already applied for this scholarship.'], 400);
        }

        $application = Application::create([
            'user_id' => $user->id,
            'scholarship_id' => $scholarship->id,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully!',
            'data' => $application
        ], 201);
    }

    // 2. Provider/Admin manages application status
    public function updateStatus(Request $request, Application $application)
    {
        $user = Auth::guard('sanctum')->user();

        // Security: Only the Provider who owns the scholarship (or an Admin) can change status
        if ($user->role !== 'admin' && $user->id !== $application->scholarship->user_id) {
            return response()->json(['message' => 'Unauthorized to manage this application.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $application->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application status updated to ' . $request->status,
            'data' => $application
        ]);
    }
}