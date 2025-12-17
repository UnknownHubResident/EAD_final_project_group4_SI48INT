<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Scholarship;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Show application form
     */
    public function create()
    {
        // Prevent duplicate application
        $existingApplication = Application::where('user_id', Auth::id())->first();

        if ($existingApplication) {
            return redirect()
                ->route('application.history')
                ->withErrors('You have already submitted an application.');
        }

        $scholarships = Scholarship::all();
        return view('student.apply', compact('scholarships'));
    }

    /**
     * Store student application
     */
    public function store(Request $request)
    {
        $request->validate([
            'scholarship_id' => 'required|exists:scholarships,id',
        ]);

        // Check for duplicate
        $duplicate = Application::where('user_id', Auth::id())
            ->where('scholarship_id', $request->scholarship_id)
            ->exists();

        if ($duplicate) {
            return redirect()
                ->back()
                ->withErrors('You already applied for this scholarship.');
        }

        Application::create([
            'user_id' => Auth::id(),
            'scholarship_id' => $request->scholarship_id,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('application.history')
            ->with('success', 'Application submitted successfully!');
    }

    /**
     * View application history
     */
    public function history()
    {
        $applications = Application::with('documents', 'scholarship')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.application_history', compact('applications'));
    }

    /**
     * Admin: List all applications
     */
    public function indexAdmin()
    {
        $applications = Application::with('user', 'scholarship', 'documents')
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Admin: View single application
     */
    public function showAdmin(Application $application)
    {
        $application->load('user', 'scholarship', 'documents');
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Admin: Approve application
     */
    public function approve(Application $application)
    {
        $application->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->route('admin.applications.index')
            ->with('success', 'Application approved successfully!');
    }

    /**
     * Admin: Reject application
     */
    public function reject(Request $request, Application $application)
    {
        $request->validate([
            'remarks' => 'required|string|min:10|max:500',
        ]);

        $application->update([
            'status' => 'rejected',
            'remarks' => $request->remarks,
        ]);

        return redirect()
            ->route('admin.applications.index')
            ->with('success', 'Application rejected successfully!');
    }
}
