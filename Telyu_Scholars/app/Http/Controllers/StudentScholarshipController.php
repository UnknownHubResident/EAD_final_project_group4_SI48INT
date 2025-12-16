<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\Major;
use Illuminate\Http\Request;

class StudentScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::with('majors')->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('major')) {
            $query->whereHas('majors', function ($q) use ($request) {
                $q->where('majors.id', $request->major);
            });
        }

        if ($request->get('sort_deadline') == 'desc') {
            $query->orderBy('deadline', 'desc');
        } else {
            $query->orderBy('deadline', 'asc');
        }

        $scholarships = $query->paginate(9)->withQueryString();
        $majors = Major::all(); 

        return view('student.scholarships.index', compact('scholarships', 'majors'));
    }

   public function show(Scholarship $scholarship)
    {
        if (!$scholarship->is_active) {
            return redirect()->route('student.scholarships.index')
                             ->with('error', 'This scholarship is currently unavailable.');
        }
        return view('student.scholarships.show', compact('scholarship'));
    }
}