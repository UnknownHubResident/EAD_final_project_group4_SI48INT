<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Major;        
use App\Models\Scholarship;  

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Logika untuk STUDENT
        if ($user->role === 'student') {
            
            $majors = Major::all();

            $scholarships = Scholarship::with('majors')
                ->where('is_active', true)
                ->latest()
                ->paginate(9);

            // Ini mengarah ke resources/views/dashboard/student.blade.php
            return view('dashboard.student', compact('majors', 'scholarships'));
        }

        // 2. Logika untuk PROVIDER
        if ($user->role === 'scholar_provider') {
            // PERBAIKAN: Mengarah ke resources/views/dashboard/scholar_provider.blade.php
            return view('dashboard.scholar_provider'); 
        }

        // 3. Logika untuk ADMIN
        if ($user->role === 'admin') {
            // PERBAIKAN: Mengarah ke resources/views/dashboard/admin.blade.php
            return view('dashboard.admin'); 
        }

        // Default fallback (Jika role tidak dikenali, logout atau tampilkan 403)
        abort(403, 'Unauthorized action.');
    }
}
