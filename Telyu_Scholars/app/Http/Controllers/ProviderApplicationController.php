<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\StudentApplication;

class ProviderApplicationController extends Controller
{
    public function __construct()
    {
        
    }
    
    /**
     * Display a list of all applications for the Provider's scholarships. (Plan Point 7)
     */
    public function index()
    {
        $providerId = Auth::id();

        // Fetch applications for scholarships created by the current provider
        $applications = StudentApplication::whereHas('scholarship', function ($query) use ($providerId) {
            $query->where('user_id', $providerId);
        })
        ->with(['scholarship', 'user']) // Eager load related data
        ->latest()
        ->get();
        
        return view('provider.application.index', compact('applications'));
    }

    /**
     * Display the details of a specific student application. (Plan Point 8)
     */
    public function show(StudentApplication $application)
    {
        
        if ($application->scholarship->user_id !== Auth::id()) {
            return redirect()->route('provider.applications.index')->with('error', 'Unauthorized access to application details.');
        }

        return view('provider.application.show', compact('application'));
    }

    /**
     * Handles the download of a specific document (transcript or student ID). (Plan Point 9)
     */
    public function downloadDocument(StudentApplication $application, $documentType)
    {
        
        if ($application->scholarship->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

       $path = match ($documentType) {
            'transcript'        => $application->transcript_path,
            'student_id'        => $application->student_id_path,
            'motivation_letter' => $application->motivation_letter, 
            default             => abort(404, 'Invalid document type.'),
        };

        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'Document not found.');
        }
        
      
        return Storage::disk('private')->download($path);
    }
    
    /**
     * Handles updating the application status to 'approved'. (Plan Point 10)
     */
    public function approve(StudentApplication $application)
    {
        
        if ($application->scholarship->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized to approve this application.');
        }
        
        
        if ($application->status !== 'pending') {
            return back()->with('error', 'Application is not pending review.');
        }

        $application->update(['status' => 'approved']);
        
        return redirect()->route('provider.applications.index')
                         ->with('success', 'Application for ' . $application->user->name . ' has been approved!');
    }

    /**
     * Shows the form to reject an application. (Plan Point 11)
     */
    public function showRejectForm(StudentApplication $application)
    {
        
        if ($application->scholarship->user_id !== Auth::id()) {
            return redirect()->route('provider.applications.index')->with('error', 'Unauthorized access.');
        }
        
        if ($application->status !== 'pending') {
            return redirect()->route('provider.applications.index')->with('error', 'Only pending applications can be rejected.');
        }
        
        return view('provider.application.reject_form', compact('application'));
    }
    
    /**
     * Handles updating the application status to 'rejected' with a reason. (Plan Point 11)
     */
    public function reject(Request $request, StudentApplication $application)
    {
       
        if ($application->scholarship->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized to reject this application.');
        }

        $request->validate(['rejection_reason' => 'required|string|min:10|max:500']);

        
        if ($application->status !== 'pending') {
            return back()->with('error', 'Application is not pending review.');
        }

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);
        
        return redirect()->route('provider.applications.index')
                         ->with('success', 'Application for ' . $application->user->name . ' has been rejected.');
    }
}
