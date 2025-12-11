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
        
        $viewPath = $this->getViewPath(); 
        $user = Auth::user();

        $query = Scholarship::latest();

        if ($user->role === 'scholar_provider')
        {
            $query->where('user_id', $user->id);
        }
        
       
        $scholarships = $query->paginate(10);
        
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

        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('scholarships', 'public');
        }

        Scholarship::create($data);

        // Redirect uses the route name, which is correct
        $routePrefix = Auth::user()->role === 'admin' ? 'admin' : 'provider';
        return redirect()->route("{$routePrefix}.scholarships.index") 
            ->with('success', 'Scholarship created successfully.');
    }

    public function edit(Scholarship $scholarship)
    {
        // GET THE CORRECT VIEW PATH
        if (Auth::user()->role !== 'admin') {
        if ($scholarship->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

        $viewPath = $this->getViewPath();
        
        // DYNAMICALLY LOAD THE VIEW
        return view("{$viewPath}.scholarships.edit", compact('scholarship'));
    }

    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        if (Auth::user()->role !== 'admin') {
        if ($scholarship->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
        
        $data = $request->validated();

    // 1. Handle NEW image upload
    if ($request->hasFile('image')) {
        // Delete old image file
        if ($scholarship->image) {
            Storage::disk('public')->delete($scholarship->image);
        }
        // Store new image file and save the path to $data
        $data['image'] = $request->file('image')->store('scholarships', 'public');
    }
    
    // 2. Handle EXPLICIT DELETION without replacement (NEW LOGIC)
    // Checks if the 'delete_image' box was checked AND the scholarship currently has an image
    elseif ($request->filled('delete_image') && $scholarship->image) {
        // Delete the file from storage
        Storage::disk('public')->delete($scholarship->image);
        // Set the image column to NULL in the database
        $data['image'] = NULL;
    }
    // 3. If no file uploaded and no deletion requested, the image key is omitted, 
    // and the original image path remains in the database.

    $scholarship->update($data);

    $routePrefix = Auth::user()->role === 'admin' ? 'admin' : 'provider';
    return redirect()->route("{$routePrefix}.scholarships.index")->with('success', 'Scholarship updated.');
    }

    public function destroy(Scholarship $scholarship)
    {   
        if (Auth::user()->role !== 'admin') {
        if ($scholarship->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

        // ... (Destroy logic remains the same) ...
        if ($scholarship->image) {
            Storage::disk('public')->delete($scholarship->image);
        }

        $scholarship->delete();

        $routePrefix = Auth::user()->role === 'admin' ? 'admin' : 'provider';
    return redirect()->route("{$routePrefix}.scholarships.index")->with('success', 'Scholarship deleted.');
    }
}

    
