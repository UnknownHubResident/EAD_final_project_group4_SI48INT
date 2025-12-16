<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scholarship;

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
            $query->orderBy('deadline', $request->sort_deadline);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'deadline' => 'required|date',
            'quota' => 'required|integer',
            'user_id' => 'required|exists:users,id'

        ]);

        $scholarship = Scholarship::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Scholarship created successfully',
            'data' => $scholarship
        ], 201);
    }

}
