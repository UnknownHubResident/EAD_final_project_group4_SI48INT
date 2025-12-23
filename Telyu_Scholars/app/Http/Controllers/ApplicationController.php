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
    // --- STUDENT SIDE ---
    
    public function index()
   {
    
    $applications = Application::with('scholarship')
        ->where('user_id', Auth::id())
        ->latest()
        ->paginate(10);

 
    return view('student.dashboardapplication.index', compact('applications'));
    }

    public function create(Scholarship $scholarship)
    {
        
        if (!$scholarship->is_active) {
            return redirect()->route('scholarships.index')->with('error', 'Scholarship deactivated.');
        }

       
        $exists = Application::where('user_id', Auth::id())
    ->where('scholarship_id', $scholarship->id)
    ->whereIn('status', ['pending', 'approved']) // Only block if not rejected
    ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'You already applied for this.');
        }

        
        $user = Auth::user();
        $defaultData = [
            'student_number' => $user->student_number ?? '',
            'study_major' => $user->study_major ?? '',
            'year_batch' => $user->year_batch ?? '',
            'degree_rank' => $user->degree_rank ?? '',
        ];

        return view('student.application.create', compact('scholarship', 'defaultData'));
    }

    public function store(Request $request, Scholarship $scholarship)
    {
        
        $request->validate([
            'student_number' => 'required|string',
            'study_major'    => 'required|string',
            'year_batch'     => 'required|string',
            'degree_rank'    => 'required|string',
            'motivation_letter' => 'required|file|mimes:pdf|max:2048',
            'transcript'     => 'required|file|mimes:pdf|max:2048',
            'student_id'     => 'required|file|mimes:jpg,png,pdf|max:1024',
        ]);

        

        
        $application = Application::create([
            'user_id' => Auth::id(),
            'scholarship_id' => $scholarship->id,
            'student_number' => $request->student_number,
            'study_major' => $request->study_major,
            'year_batch' => $request->year_batch,
            'degree_rank' => $request->degree_rank,
            'status' => 'pending',
        ]);

        
        $filesToUpload = [
            'motivation_letter' => $request->file('motivation_letter'),
            'transcript' => $request->file('transcript'),
            'student_id' => $request->file('student_id'),
        ];

        foreach ($filesToUpload as $type => $file) {
            if ($file) {
                $path = $file->store('documents/' . Auth::id(), 'public');
                $application->documents()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $type,
                ]);
            }
        }

        return redirect()->route('student.applications.index')->with('success', 'Submitted!');
    }

    // --- ADMIN SIDE 

    public function indexAdmin()
    {
        $applications = Application::with('user', 'scholarship')->paginate(15);
        return view('admin.applications.index', compact('applications'));
    }

    public function approve(Application $application)
    {
        $application->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Approved!');
    }
}