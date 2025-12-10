<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class StudentScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::query()->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $scholarships = $query->orderBy('deadline')->paginate(9)->withQueryString();

        return view('student.scholarships.index', compact('scholarships'));
    }

    public function show(Scholarship $scholarship)
    {
        if (!$scholarship->is_active && auth()->check() && auth()->user()->role === 'student') {
            abort(404);
        }

        return view('student.scholarships.show', compact('scholarship'));
    }
}
