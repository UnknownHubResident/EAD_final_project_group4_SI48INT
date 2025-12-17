<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\Major;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProviderScholarshipController extends Controller
{
    private function getViewPath()
    {
        return Auth::user()->role === 'admin' ? 'admin' : 'provider';
    }

    public function index()
    {
        $viewPath = $this->getViewPath();
        $user = Auth::user();
        $query = Scholarship::latest();

        if ($user->role === 'scholar_provider') {
            $query->where('user_id', $user->id);
        }

        $scholarships = $query->paginate(10);
        return view("{$viewPath}.scholarships.index", compact('scholarships'));
    }

    public function create()
    {
        $majors = Major::orderBy('name')->get();
        return view("{$this->getViewPath()}.scholarships.create", compact('majors'));
    }

    public function store(StoreScholarshipRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        }

        $scholarship = Scholarship::create($data);

        if ($request->filled('majors')) {
            $scholarship->majors()->sync($request->majors);
        }

        return redirect()->route("{$this->getViewPath()}.scholarships.index")
            ->with('success', 'Scholarship created successfully.');
    }

    public function edit(Scholarship $scholarship)
    {
        if (Auth::user()->role !== 'admin' && $scholarship->user_id !== Auth::id()) {
            abort(403);
        }

        $majors = Major::orderBy('name')->get();
        return view("{$this->getViewPath()}.scholarships.edit", compact('scholarship', 'majors'));
    }

    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        if (Auth::user()->role !== 'admin' && $scholarship->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($scholarship->image) {
                Storage::disk('public')->delete($scholarship->image);
            }
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        } elseif ($request->boolean('delete_image') && $scholarship->image) {
            Storage::disk('public')->delete($scholarship->image);
            $data['image'] = null;
        }

        $scholarship->update($data);

        if ($request->has('majors')) {
            $scholarship->majors()->sync($request->majors);
        }

        return redirect()->route("{$this->getViewPath()}.scholarships.index")
            ->with('success', 'Scholarship updated successfully.');
    }

    public function destroy(Scholarship $scholarship)
    {
        if (Auth::user()->role !== 'admin' && $scholarship->user_id !== Auth::id()) {
            abort(403);
        }

        if ($scholarship->image) {
            Storage::disk('public')->delete($scholarship->image);
        }

        $scholarship->delete();
        return redirect()->route("{$this->getViewPath()}.scholarships.index")
            ->with('success', 'Scholarship deleted successfully.');
    }
}