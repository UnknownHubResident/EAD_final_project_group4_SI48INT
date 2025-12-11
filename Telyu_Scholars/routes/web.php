<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Middleware\AdminMiddleware; 
use App\Http\Controllers\StudentScholarshipController; 
use App\Http\Controllers\ProviderScholarshipController; 
use Illuminate\Support\Facades\Auth; 


// ======================================================================
// 1. PUBLIC ROUTES (Login, Register, and Public Scholarship Listing)
// ======================================================================

// Root Route
Route::get('/', function () {
    return redirect()->route('student.scholarships.index'); 
});

// Auth Routes
Route::get('/register', [RegisterController::class, 'ShowRegisFrom'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Student: public listing and detail
Route::get('/scholarships', [StudentScholarshipController::class, 'index'])
    ->name('student.scholarships.index');

Route::get('/scholarships/{scholarship}', [StudentScholarshipController::class, 'show'])
    ->name('student.scholarships.show');


// ======================================================================
// 2. PROTECTED ROUTES (Requires User to be LOGGED IN)
// ======================================================================
Route::middleware(['auth'])->group(function () {
    
    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 

    // Unified Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ------------------------------------------------------------------
    // 2.A: PROVIDER ONLY SCHOLARSHIP MANAGEMENT (MODIFIED)
    // ------------------------------------------------------------------
    Route::middleware(['role:scholar_provider']) // <-- Only Provider allowed
        ->prefix('provider')
        ->name('provider.')
        ->group(function () {
            Route::resource('scholarships', ProviderScholarshipController::class)
                ->except(['show']);
        });

    
    // ------------------------------------------------------------------
    // 3. ADMIN ONLY ROUTES (Requires Auth AND 'admin' role)
    // ------------------------------------------------------------------
    Route::middleware(['auth', AdminMiddleware::class]) 
        ->prefix('admin') 
        ->name('admin.') 
        ->group(function () {
            
            Route::post('/approve/{user}', [AdminController::class, 'approveProvider'])->name('approve'); 
            Route::get('/pending', [AdminController::class, 'showPendingProviders'])->name('pending'); 

            // ADDED: Admin's dedicated Scholarship Management
            Route::resource('scholarships', ProviderScholarshipController::class) // <-- Admin's separate path
                ->except(['show']);

            // USER MANAGEMENT ROUTES (from previous steps)
            Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
            Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
            Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
            Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
            Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleActiveStatus'])->name('users.toggle');
        });
});