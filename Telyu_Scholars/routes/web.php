<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentScholarshipController;
use App\Http\Controllers\ProviderScholarshipController;
use Illuminate\Support\Facades\Auth;

Route::get('/login', function () {
    return 'Login page not implemented yet';
})->name('login');

// Role-based redirect after login
Route::get('/redirect-by-role', function () {
    $user = auth()->user();
    if (!$user) return redirect('/');
    
    return match ($user->role) {
        'admin' => redirect()->route('provider.scholarships.index'),
        'scholar_provider' => redirect()->route('provider.scholarships.index'),
        'student' => redirect()->route('student.scholarships.index'),
        default => redirect('/')
    };
})->middleware('auth')->name('redirect-by-role');

// Student: public listing and detail
Route::get('/scholarships', [StudentScholarshipController::class, 'index'])
    ->name('student.scholarships.index');

Route::get('/scholarships/{scholarship}', [StudentScholarshipController::class, 'show'])
    ->name('student.scholarships.show');

// Provider/Admin: manage scholarships
Route::middleware(['auth', 'role:scholar_provider,admin'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {
        Route::resource('scholarships', ProviderScholarshipController::class)
            ->except(['show']);
    });
