<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
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

        // Ensure providers only see their own scholarships
        if ($user->role === 'scholar_provider') {
            $query->where('user_id', $user->id);
        }
        
        $scholarships = $query->paginate(10);
        
        return view("{$viewPath}.scholarships.index", compact('scholarships'));
    }

    public function create()
    {
        return view("{$this->getViewPath()}.scholarships.create");
    }

    public function store(StoreScholarshipRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        }

        Scholarship::create($data);

        $prefix = $this->getViewPath();
        return redirect()->route("{$prefix}.scholarships.index") 
            ->with('success', 'Scholarship created successfully.');
    }

    public function edit(Scholarship $scholarship)
    {
        // Security Check
        if (Auth::user()->role !== 'admin' && $scholarship->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view("{$this->getViewPath()}.scholarships.edit", compact('scholarship'));
    }

    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        // Security Check
        if (Auth::user()->role !== 'admin' && $scholarship->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $data = $request->validated();

        // Handle Activation Toggle
        $data['is_active'] = $request->has('is_active');

        // Handle Image Upload/Deletion
        if ($request->hasFile('image')) {
            if ($scholarship->image) {
                Storage::disk('public')->delete($scholarship->image);
            }
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        } 
        // Logic restored: Delete image if checkbox is checked
        elseif ($request->boolean('delete_image') && $scholarship->image) {
            Storage::disk('public')->delete($scholarship->image);
            $data['image'] = null;
        }

        $scholarship->update($data);

        $prefix = $this->getViewPath();
        return redirect()->route("{$prefix}.scholarships.index")
            ->with('success', 'Scholarship updated successfully.');
    }

    public function destroy(Scholarship $scholarship)
    {   
        // Security Check
        if (Auth::user()->role !== 'admin' && $scholarship->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($scholarship->image) {
            Storage::disk('public')->delete($scholarship->image);
        }

        $scholarship->delete();

        $prefix = $this->getViewPath();
        return redirect()->route("{$prefix}.scholarships.index")
            ->with('success', 'Scholarship deleted successfully.');
    }
}