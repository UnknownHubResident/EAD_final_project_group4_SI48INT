<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Validator; // REQUIRED IMPORT
use Illuminate\Support\Facades\Auth;

class ScholarshipApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::with('majors')
            ->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('sort_deadline')) {
            // Ensure only 'asc' or 'desc' is passed
            $direction = in_array(strtolower($request->sort_deadline), ['asc', 'desc']) 
                         ? $request->sort_deadline : 'asc';
            $query->orderBy('deadline', $direction);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
       
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = Auth::guard('sanctum')->user();
    if ($user->role !== 'scholar_provider' && $user->role !== 'admin') {
        return response()->json([
            'success' => false,
            'message' => 'Access denied. Only Scholarship Providers or admins can create scholarships.'
        ], 403); 
    }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'deadline' => 'required|date',
            'quota' => 'required|integer',
        ]);

        if ($validator->fails()) {
          
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

       
        $scholarship = Scholarship::create(array_merge(
            $validator->validated(),
            ['user_id' => Auth::guard('sanctum')->id()] 
        ));

        return response()->json([
            'success' => true,
            'message' => 'Scholarship created successfully',
            'data' => $scholarship
        ], 201); 
    }
}