<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::latest()->paginate(10);
        return view('scholarships.index', compact('scholarships'));
    }

    public function show(Scholarship $scholarship)
    {
        return view('scholarships.show', compact('scholarship'));
    }

}
