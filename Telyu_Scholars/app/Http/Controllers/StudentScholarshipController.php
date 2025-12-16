<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class StudentScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $scholarships = $query->latest()->paginate(10);

       
        return view('student.scholarships.index', compact('scholarships'));
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
