<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Middleware\AdminMiddleware; 
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\StudentScholarshipController; 
use App\Http\Controllers\StudentApplicationController;
use App\Http\Controllers\ProviderScholarshipController; 
use App\Http\Controllers\ProviderApplicationController;
use App\Http\Middleware\ProviderRole;
use Illuminate\Support\Facades\Auth; 

// 1. PUBLIC ROUTES
Route::get('/', function () {
    if (Auth::check()){
        return redirect()->route('dashboard');
    }
    return redirect()->route('student.scholarships.index'); 
});

Route::get('/register', [RegisterController::class, 'ShowRegisFrom'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/scholarships', [StudentScholarshipController::class, 'index'])->name('student.scholarships.index');
Route::get('/scholarships/{scholarship}', [StudentScholarshipController::class, 'show'])->name('student.scholarships.show');

// 2. PROTECTED ROUTES
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2.A: STUDENT ONLY
    Route::controller(StudentApplicationController::class)
        ->prefix('student/applications')
        ->name('student.applications.') 
        ->group(function () {
            Route::get('/', 'index')->name('index'); 
            Route::get('/create/{scholarship}', 'create')->name('create'); 
            Route::post('/store/{scholarship}', 'store')->name('store');
        });
        
    // 2.B: PROVIDER ONLY
    Route::middleware([ProviderRole::class]) 
        ->prefix('provider')
        ->name('provider.')
        ->group(function () {
            Route::resource('scholarships', ProviderScholarshipController::class)->except(['show']);

            Route::controller(ProviderApplicationController::class)
                ->prefix('applications')
                ->name('applications.')
                ->group(function () {
                    Route::get('/', 'index')->name('index'); 
                    Route::get('/{application}', 'show')->name('show'); 
                    Route::post('/{application}/approve', 'approve')->name('approve'); 
                    Route::get('/{application}/reject/form', 'showRejectForm')->name('reject.form'); 
                    Route::post('/{application}/reject', 'reject')->name('reject'); 
                    Route::get('/{application}/download/{documentType}', 'downloadDocument')->name('download');
                });
        });

    // 3. ADMIN ONLY
    Route::middleware(['auth', AdminMiddleware::class]) 
        ->prefix('admin') 
        ->name('admin.') 
        ->group(function () {
            
            // Provider Approval & Rejection Logic
            Route::get('/pending', [AdminController::class, 'showPendingProviders'])->name('pending'); 
            Route::post('/approve/{user}', [AdminController::class, 'approveProvider'])->name('approve'); 
            Route::get('/providers/{user}/reject/form', [AdminController::class, 'showRejectForm'])->name('reject.form'); 
            Route::post('/providers/{user}/reject', [AdminController::class, 'finalizeReject'])->name('reject.finalize');
            Route::post('/providers/{user}/unreject', [AdminController::class, 'unrejectProvider'])->name('unreject');

            Route::resource('scholarships', ProviderScholarshipController::class)->except(['show']);

            Route::controller(AdminUserController::class)->prefix('users')->name('users.')->group(function () {
                Route::get('/', 'index')->name('index'); 
                Route::get('/{user}', 'show')->name('show'); 
                Route::put('/{user}/toggle-status', 'toggleStatus')->name('toggleStatus'); 
                Route::delete('/{user}', 'destroy')->name('destroy'); 
            });        
        });
});