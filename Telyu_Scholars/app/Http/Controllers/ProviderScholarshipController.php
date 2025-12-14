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
    // 🔹 Determine view prefix based on role
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
        $viewPath = $this->getViewPath();

        $majors = Major::orderBy('name')->get();

        return view("{$viewPath}.scholarships.create", compact('majors'));
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

        $routePrefix = Auth::user()->role === 'admin' ? 'admin' : 'provider';

        return redirect()
            ->route("{$routePrefix}.scholarships.index")
            ->with('success', 'Scholarship created successfully.');
    }

    public function edit(Scholarship $scholarship)
    {
        if (Auth::user()->role !== 'admin' && $scholarship->user_id !== Auth::id()) {
            abort(403);
        }

        $viewPath = $this->getViewPath();
        $majors = Major::orderBy('name')->get();

        return view("{$viewPath}.scholarships.edit", compact('scholarship', 'majors'));
    }

    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        if (Auth::user()->role !== 'admin' && $scholarship->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($scholarship->image) {
                Storage::disk('public')->delete($scholarship->image);
            }
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        } elseif ($request->filled('delete_image')) {
            Storage::disk('public')->delete($scholarship->image);
            $data['image'] = null;
        }

        $scholarship->update($data);

        if ($request->filled('majors')) {
            $scholarship->majors()->sync($request->majors);
        }

        $routePrefix = Auth::user()->role === 'admin' ? 'admin' : 'provider';

        return redirect()
            ->route("{$routePrefix}.scholarships.index")
            ->with('success', 'Scholarship updated.');
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

        $routePrefix = Auth::user()->role === 'admin' ? 'admin' : 'provider';

        return redirect()
            ->route("{$routePrefix}.scholarships.index")
            ->with('success', 'Scholarship deleted.');
    }
}
