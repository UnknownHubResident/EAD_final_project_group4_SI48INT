<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\Major;

class StudentScholarshipController extends Controller
{
    public function index(Request $request)
    {
        dd($request->all());
        $query = Scholarship::with('majors')
            ->where('is_active', true);

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // 🎓 FILTER MAJOR
        if ($request->filled('major')) {
            $query->whereHas('majors', function ($q) use ($request) {
                $q->where('majors.id', $request->major);
            });
        }

        // 📅 SORT DEADLINE
        if ($request->get('sort_deadline') == 'desc') {
            // Farthest: Dari tanggal terbesar (2026) ke terkecil
            $query->orderBy('deadline', 'desc');
        } elseif ($request->get('sort_deadline') == 'asc') {
            // Nearest: Dari tanggal terkecil (2025) ke terbesar
            $query->orderBy('deadline', 'asc'); 
        } else {
            // Default: Kalau tidak ada filter, urutkan berdasarkan deadline terdekat
            // (Biar user liat yg mepet dulu)
            $query->orderBy('deadline', 'asc');
        }

        $scholarships = $query->paginate(9)->withQueryString();
        $majors = Major::orderBy('name')->get();

        return view('student.scholarships.index', compact('scholarships', 'majors'));
    }

}