<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Scholarship;
use App\Models\StudentApplication;
use App\Http\Controllers\Controller;
use App\Http\Middleware\StudentRole;

class StudentApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(StudentRole::class); 
    }

    /**
     * Shows the application form for a specific scholarship. (Plan Point 3)
     */
    public function create(Scholarship $scholarship)
    {
        // Check if the scholarship is active (Plan Point 15)
        if (!$scholarship->is_active) {
            return redirect()->route('scholarships.index')->with('error', 'This scholarship is currently deactivated and cannot be applied for.');
        }

        // Check if the student has any active application for this scholarship
        $activeApplication = Auth::user()->applications()
            ->where('scholarship_id', $scholarship->id)
            ->whereIn('status', ['applied', 'pending'])
            ->exists();

        if ($activeApplication) {
            return redirect()->route('student.dashboard')->with('info', 'You already have an active application for this scholarship.');
        }

        $user = Auth::user();
        
        // Data for auto-fill (Plan Point 4)
        $defaultData = [
            'student_number' => $user->student_number ?? '',
            'study_major' => $user->study_major ?? '',
            'year_batch' => $user->year_batch ?? '',
            'degree_rank' => $user->degree_rank ?? '',
        ];

        return view('student.application.create', compact('scholarship', 'defaultData'));
    }

    /**
     * Handles the form submission and data saving. (Plan Point 3)
     */
    public function store(Request $request, Scholarship $scholarship)
    {
        
        $request->validate([
            'motivation_letter' => 'required|file|mimes:pdf|max:2048',
            'transcript' => 'required|file|mimes:pdf|max:2048', 
            'student_id' => 'required|file|mimes:jpg,png,pdf|max:1024',
            'student_number' => 'required|string|max:20',
            'study_major' => 'required|string|max:100',
            'year_batch' => 'required|string|max:10',
            'degree_rank' => 'required|string|max:10',
        ]);
        
        $userId = Auth::id();
        
       

        $motivationLetterPath = $request->file('motivation_letter')->store('motivation_letters/'.$userId, 'private');
        $transcriptPath = $request->file('transcript')->store('transcripts/'.$userId, 'private');
        $studentIdPath = $request->file('student_id')->store('student_ids/'.$userId, 'private');

       
        StudentApplication::create([
            'user_id' => $userId,
            'scholarship_id' => $scholarship->id,
            'motivation_letter' => $motivationLetterPath,
            'transcript_path' => $transcriptPath,
            'student_id_path' => $studentIdPath,
            'student_number' => $request->student_number,
            'study_major' => $request->study_major,
            'year_batch' => $request->year_batch,
            'degree_rank' => $request->degree_rank,
            'status' => 'pending', 
        ]);

        //Redirect to student dashboard 
        return redirect()->route('student.applications.index')->with('success', 'Your application has been successfully submitted and is now pending review!');
    }

    /**
     * Displays the Student Dashboard with applications. (Plan Point 6)
     */
    public function index()
    {
        
        $applications = Auth::user()->applications()->with('scholarship')->get();
        return view('student.dashboardapplication.index', compact('applications'));
    }
}
