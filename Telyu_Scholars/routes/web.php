<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProviderScholarshipController; 
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentScholarshipController;
use App\Http\Controllers\ProviderApplicationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\BookingController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ProviderRole;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('student.dashboard');
    }
    return redirect()->route('student.scholarships.index');
});

Route::get('/register', [RegisterController::class, 'ShowRegisFrom'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/scholarships', [StudentScholarshipController::class, 'index'])->name('student.scholarships.index');
Route::get('/scholarships/{scholarship}', [StudentScholarshipController::class, 'show'])->name('student.scholarships.show');

/*
|--------------------------------------------------------------------------
| Protected Routes (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard'); 

    // 1. STUDENT SPECIFIC ROUTES
    Route::prefix('student/applications')->name('student.applications.')->group(function () {
        Route::get('/', [ApplicationController::class, 'index'])->name('index');
        Route::get('/create/{scholarship}', [ApplicationController::class, 'create'])->name('create');
        Route::post('/store/{scholarship}', [ApplicationController::class, 'store'])->name('store');
    });

    // NEW STUDENT MENTORSHIP & BOOKING WEB ROUTING ACTIONS
    Route::prefix('student/bookings')->name('student.bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'studentIndex'])->name('index');
        Route::get('/create', [BookingController::class, 'studentCreate'])->name('create');
        Route::post('/store', [BookingController::class, 'studentStore'])->name('store');
    });

    // 2. SCHOLARSHIP PROVIDER ROUTES
    Route::middleware([ProviderRole::class])
        ->prefix('provider')
        ->name('provider.')
        ->group(function () {
            Route::resource('scholarships', ProviderScholarshipController::class)->except(['show']);
            
            Route::controller(ProviderApplicationController::class)->prefix('applications')->name('applications.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{application}', 'show')->name('show');
                Route::post('/{application}/approve', 'approve')->name('approve');
                Route::get('/{application}/reject/form', 'showRejectForm')->name('reject.form');
                Route::post('/{application}/reject', 'reject')->name('reject');
                Route::get('/download/{document}', 'downloadDocument')->name('download');
            });
        });

    // 3. ADMIN ROUTES
    Route::middleware([AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            
            Route::resource('scholarships', ProviderScholarshipController::class);
            
            Route::get('/pending', [AdminController::class, 'showPendingProviders'])->name('pending');
            Route::post('/approve/{user}', [AdminController::class, 'approveProvider'])->name('approve');
            
            // Rejection Routes
            Route::get('/providers/{user}/reject/form', [AdminController::class, 'showRejectForm'])->name('reject.form');
            Route::post('/providers/{user}/reject', [AdminController::class, 'finalizeReject'])->name('reject.finalize');
            
            Route::post('/providers/{user}/unreject', [AdminController::class, 'unrejectProvider'])->name('unreject');
            
            Route::controller(AdminUserController::class)->prefix('users')->name('users.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{user}', 'show')->name('show');
                Route::put('/{user}/toggle-status', 'toggleStatus')->name('toggleStatus');
                Route::delete('/{user}', 'destroy')->name('destroy');
            });

            // ==========================================
            // MENTORSHIP & CONSULTATION MODULES
            // ==========================================
            Route::prefix('mentors')->name('mentors.')->group(function () {
                Route::get('/', [MentorController::class, 'index'])->name('index');
                Route::get('/create', [MentorController::class, 'create'])->name('create');
                Route::post('/', [MentorController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [MentorController::class, 'edit'])->name('edit');
                Route::put('/{id}', [MentorController::class, 'update'])->name('update');
                Route::delete('/{id}', [MentorController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('bookings')->name('bookings.')->group(function () {
                Route::get('/', [BookingController::class, 'index'])->name('index');
                Route::get('/{id}', [BookingController::class, 'show'])->name('show');
                Route::post('/{id}/update-status', [BookingController::class, 'updateStatus'])->name('updateStatus');
                
                // HERE IS THE ADDED DELETE ROUTE FOR THE ADMIN DISMISSAL ACTION:
                Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
            });
        });
});