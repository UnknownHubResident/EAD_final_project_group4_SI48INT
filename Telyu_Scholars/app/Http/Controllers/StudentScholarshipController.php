<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\Major; // <--- JANGAN LUPA IMPORT INI
use Illuminate\Http\Request;

class StudentScholarshipController extends Controller
{
    public function index(Request $request)
    {
        // 1. Base Query (+ with 'majors' biar loading cepat)
        $query = Scholarship::with('majors')->where('is_active', true);

        // 2. Logic Search (Judul)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        // 3. Logic Filter Major (Jurusan)
        // Tambahkan ini supaya dropdown "Major" berfungsi memfilter data
        if ($request->filled('major')) {
            $query->whereHas('majors', function ($q) use ($request) {
                $q->where('majors.id', $request->major);
            });
        }

        // 4. Logic Sort Deadline
        if ($request->get('sort_deadline') == 'desc') {
            // Farthest (Paling Jauh: 2026 dulu)
            $query->orderBy('deadline', 'desc');
        } else {
            // Default / Nearest (Paling Dekat: 2025 dulu)
            $query->orderBy('deadline', 'asc');
        }

        // 5. Eksekusi Query
        $scholarships = $query->paginate(9)->withQueryString();

        // 6. Ambil Data Majors (WAJIB ADA)
        // Tanpa ini, view akan error "Undefined variable $majors"
        $majors = Major::all(); 

        // Kirim $scholarships DAN $majors ke view
        return view('student.scholarships.index', compact('scholarships', 'majors'));
    }

    public function show(Scholarship $scholarship)
    {
        if (!$scholarship->is_active && auth()->check() && auth()->user()->role === 'student') {
            abort(404);
        }

        return view('student.scholarships.show', compact('scholarship'));
    }
}