<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Store uploaded document
     */
    public function store(Request $request)
    {
        // Validate file input
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Get student's application
        $application = Application::where('user_id', Auth::id())->firstOrFail();

        // Store file
        $file = $request->file('document');
        $path = $file->store('documents');

        // Save document info in DB
        Document::create([
            'application_id' => $application->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Document uploaded successfully.');
    }
}
