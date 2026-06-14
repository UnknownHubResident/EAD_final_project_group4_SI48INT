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
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Define the physical web directory path
            $destinationPath = public_path('images/scholarships');
            
            // Automatically build directories if they don't exist yet
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // Save the file physically inside public/images/scholarships/
            $image->move($destinationPath, $imageName);
            
            // Store the asset path string to the database
            $data['image'] = 'images/scholarships/' . $imageName;
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
            // Delete the old file from the public directory if it exists
            if ($scholarship->image && file_exists(public_path($scholarship->image))) {
                unlink(public_path($scholarship->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('images/scholarships');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $image->move($destinationPath, $imageName);
            $data['image'] = 'images/scholarships/' . $imageName;

        } elseif ($request->boolean('delete_image') && $scholarship->image) {
            // Remove file from disk when explicitly requested
            if (file_exists(public_path($scholarship->image))) {
                unlink(public_path($scholarship->image));
            }
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

        // Clean up the image file upon model deletion
        if ($scholarship->image && file_exists(public_path($scholarship->image))) {
            unlink(public_path($scholarship->image));
        }

        $scholarship->delete();
        return redirect()->route("{$this->getViewPath()}.scholarships.index")
            ->with('success', 'Scholarship deleted successfully.');
    }
}