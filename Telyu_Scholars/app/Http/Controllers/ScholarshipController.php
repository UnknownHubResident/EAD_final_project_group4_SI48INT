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

    public function create()
    {
        return view('scholarships.create');
    }

    public function store(StoreScholarshipRequest $request)
    {
        Scholarship::create($request->validated());

        return redirect()
            ->route('scholarships.index')
            ->with('success', 'Scholarship created successfully!');
    }

    public function show(Scholarship $scholarship)
    {
        return view('scholarships.show', compact('scholarship'));
    }

    public function edit(Scholarship $scholarship)
    {
        return view('scholarships.edit', compact('scholarship'));
    }

    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        $scholarship->update($request->validated());

        return redirect()
            ->route('scholarships.index')
            ->with('success', 'Scholarship updated successfully!');
    }

    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();

        return redirect()
            ->route('scholarships.index')
            ->with('success', 'Scholarship deleted successfully!');
    }
}
