<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // <--- NEW: Import Auth facade

class ProviderScholarshipController extends Controller
{   
    
    
    // <--- NEW: Private function to check role and set view path --->
    private function getViewPath()
    {
        // Check if the current user is an admin or fall back to provider
        return Auth::user()->role === 'admin' ? 'admin' : 'provider';
    }
    // <----------------------------------------------------------------->

    public function index()
    {
        // GET THE CORRECT VIEW PATH
        $viewPath = $this->getViewPath(); 
        
        // You might add logic here later to filter scholarships by the user's ID
        // For now, it fetches all:
        $scholarships = Scholarship::latest()->paginate(10);
        
        // DYNAMICALLY LOAD THE VIEW (e.g., 'admin.scholarships.index' or 'provider.scholarships.index')
        return view("{$viewPath}.scholarships.index", compact('scholarships'));
    }

    public function create()
    {
        // GET THE CORRECT VIEW PATH
        $viewPath = $this->getViewPath(); 
        
        // DYNAMICALLY LOAD THE VIEW
        return view("{$viewPath}.scholarships.create");
    }

    public function store(StoreScholarshipRequest $request)
    {
        // ... (Store logic remains the same) ...
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        }

        Scholarship::create($data);

        // Redirect uses the route name, which is correct
        return redirect()->route('provider.scholarships.index') 
            ->with('success', 'Scholarship created successfully.');
    }

    public function edit(Scholarship $scholarship)
    {
        // GET THE CORRECT VIEW PATH
        $viewPath = $this->getViewPath();
        
        // DYNAMICALLY LOAD THE VIEW
        return view("{$viewPath}.scholarships.edit", compact('scholarship'));
    }

    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        // ... (Update logic remains the same) ...
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
        // ... (Destroy logic remains the same) ...
        if ($scholarship->image) {
            Storage::disk('public')->delete($scholarship->image);
        }

        $scholarship->delete();

        return redirect()->route('provider.scholarships.index')->with('success', 'Scholarship deleted.');
    }

    
}