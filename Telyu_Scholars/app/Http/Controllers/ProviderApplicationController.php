<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Application; // 1. Updated Model Name
use App\Models\Document;    // Add this to handle downloads

class ProviderApplicationController extends Controller
{
    public function index()
    {
        $providerId = Auth::id();

        // 2. Point to the new 'Application' model
        $applications = Application::whereHas('scholarship', function ($query) use ($providerId) {
            $query->where('user_id', $providerId);
        })
        ->with(['scholarship', 'user', 'documents']) // Eager load documents
        ->latest()
        ->get();
        
        return view('provider.application.index', compact('applications'));
    }

    public function show(Application $application)
    {
        if ($application->scholarship->user_id !== Auth::id()) {
            abort(403);
        }

        // Load documents so the provider can see the files
        $application->load('documents');
        return view('provider.application.show', compact('application'));
    }

    public function downloadDocument(Document $document)
    {
        // 3. New way to download: We download by Document ID
        // Check if the provider owns the scholarship this document belongs to
        if ($document->application->scholarship->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }
        
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
    
    public function approve(Application $application)
    {
        if ($application->scholarship->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $application->update(['status' => 'approved']);
        
        return redirect()->route('provider.applications.index')
                         ->with('success', 'Application approved!');
    }

    public function reject(Request $request, Application $application)
    {
        if ($application->scholarship->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->validate(['remarks' => 'required|string|min:10']);

        // 4. Using 'remarks' instead of 'rejection_reason'
        $application->update([
            'status' => 'rejected',
            'remarks' => $request->remarks
        ]);
        
        return redirect()->route('provider.applications.index')
                         ->with('success', 'Application rejected.');
    }

    public function showRejectForm(Application $application)
{
    // Security check: Ensure the provider owns the scholarship for this application
    if ($application->scholarship->user_id !== Auth::id()) {
        abort(403);
    }

    return view('provider.application.reject_form', compact('application'));
}
}