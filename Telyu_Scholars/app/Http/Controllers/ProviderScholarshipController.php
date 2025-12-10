<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;
use Illuminate\Support\Facades\Storage;

class ProviderScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::latest()->paginate(10);
        return view('provider.scholarships.index', compact('scholarships'));
    }

    public function create()
    {
        return view('provider.scholarships.create');
    }

    public function store(StoreScholarshipRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        }

        Scholarship::create($data);

        return redirect()->route('provider.scholarships.index')
            ->with('success', 'Scholarship created successfully.');
    }

    public function edit(Scholarship $scholarship)
    {
        return view('provider.scholarships.edit', compact('scholarship'));
    }

    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($scholarship->image) {
                Storage::disk('public')->delete($scholarship->image);
            }
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        }

        $scholarship->update($data);

        return redirect()->route('provider.scholarships.index')->with('success', 'Scholarship updated.');
    }

    public function destroy(Scholarship $scholarship)
    {
        if ($scholarship->image) {
            Storage::disk('public')->delete($scholarship->image);
        }

        $scholarship->delete();

        return redirect()->route('provider.scholarships.index')->with('success', 'Scholarship deleted.');
    }
}
