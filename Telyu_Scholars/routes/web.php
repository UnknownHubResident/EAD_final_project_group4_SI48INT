<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; // From main
use App\Http\Controllers\AdminController; // From main
use App\Http\Controllers\Auth\LoginController; // From main
use App\Http\Controllers\Auth\RegisterController; // From main
use App\Http\Middleware\AdminMiddleware; // From main
use App\Http\Controllers\StudentScholarshipController; // From fasyaaa
use App\Http\Controllers\ProviderScholarshipController; // From fasyaaa
use Illuminate\Support\Facades\Auth; // From fasyaaa (Though often implicitly loaded)


// ======================================================================
// 1. PUBLIC ROUTES (Login, Register, and Public Scholarship Listing)
// ======================================================================

// Root Route - Redirects to register/login (From main)
Route::get('/', function () {
    return redirect()->route('register'); 
});

// Auth Routes (From main)
Route::get('/register', [RegisterController::class, 'ShowRegisFrom'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Student: public listing and detail (From fasyaaa)
Route::get('/scholarships', [StudentScholarshipController::class, 'index'])
    ->name('student.scholarships.index');

Route::get('/scholarships/{scholarship}', [StudentScholarshipController::class, 'show'])
    ->name('student.scholarships.show');


// ======================================================================
// 2. PROTECTED ROUTES (Requires User to be LOGGED IN)
// ======================================================================
Route::middleware(['auth'])->group(function () {
    
    // Logout route (From main)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 

    // Unified Dashboard (From main)
    // NOTE: This route should handle the role redirect, making the 'redirect-by-role' logic redundant.
    // If you are using the logic inside DashboardController->index, you can delete the next block.
    // I'll keep the dashboard route from 'main' as it's the standard entry point.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Provider/Admin: manage scholarships (From fasyaaa)
    // NOTE: If you are using a generic 'role' middleware (which is good), keep this block.
    Route::middleware(['role:scholar_provider,admin']) 
        ->prefix('provider')
        ->name('provider.')
        ->group(function () {
            Route::resource('scholarships', ProviderScholarshipController::class)
                ->except(['show']);
        });

    
    // ------------------------------------------------------------------
    // 3. ADMIN ONLY ROUTES (Requires Auth AND 'admin' role) (From main)
    // ------------------------------------------------------------------
    Route::middleware(['auth', AdminMiddleware::class]) 
        ->prefix('admin') 
        ->name('admin.') 
        ->group(function () {
            
            Route::post('/approve/{user}', [AdminController::class, 'approveProvider'])->name('approve'); 
            Route::get('/pending', [AdminController::class, 'showPendingProviders'])->name('pending'); 

            // USER MANAGEMENT ROUTES (from our previous steps, which were added to 'main')
            Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
            Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
            Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
            Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
            Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleActiveStatus'])->name('users.toggle');
        });
});