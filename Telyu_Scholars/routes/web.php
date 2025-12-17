<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentScholarshipController;
use App\Http\Controllers\StudentApplicationController;
use App\Http\Controllers\ProviderScholarshipController;
use App\Http\Controllers\ProviderApplicationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DocumentController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ProviderRole;
use Illuminate\Support\Facades\Auth;

// ======================================================================
// 1. PUBLIC ROUTES (Login, Register, and Public Scholarship Listing)
// ======================================================================

Route::get('/', function () {
    if (Auth::check()) {
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

// ======================================================================
// 2. PROTECTED ROUTES (Authenticated Users Only)
// ======================================================================

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ======================================================================
    // 2.A: STUDENT APPLICATION ROUTES
    // ======================================================================

    Route::get('/apply', [ApplicationController::class, 'create'])
        ->name('application.create');

    Route::post('/apply', [ApplicationController::class, 'store'])
        ->name('application.store');

    Route::get('/application/history', [ApplicationController::class, 'history'])
        ->name('application.history');

    Route::post('/documents/upload', [DocumentController::class, 'store'])
        ->name('documents.store');

    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
        ->name('documents.download');

    // Student Scholarship Routes
    Route::controller(StudentApplicationController::class)
        ->prefix('student/applications')
        ->name('student.applications.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{scholarship}', 'create')->name('create');
            Route::post('/store/{scholarship}', 'store')->name('store');
        });

    // ======================================================================
    // 2.B: PROVIDER ROUTES (Scholar Provider Only)
    // ======================================================================

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

    // ======================================================================
    // 2.C: ADMIN ROUTES (Admin Only)
    // ======================================================================

    Route::middleware(['auth', AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Provider Management
            Route::get('/pending', [AdminController::class, 'showPendingProviders'])->name('pending');
            Route::post('/approve/{user}', [AdminController::class, 'approveProvider'])->name('approve');
            Route::get('/providers/{user}/reject/form', [AdminController::class, 'showRejectForm'])->name('reject.form');
            Route::post('/providers/{user}/reject', [AdminController::class, 'finalizeReject'])->name('reject.finalize');
            Route::post('/providers/{user}/unreject', [AdminController::class, 'unrejectProvider'])->name('unreject');

            // Admin Scholarship Management
            Route::resource('scholarships', ProviderScholarshipController::class)->except(['show']);

            // Admin User Management
            Route::controller(AdminUserController::class)
                ->prefix('users')
                ->name('users.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/{user}', 'show')->name('show');
                    Route::put('/{user}/toggle-status', 'toggleStatus')->name('toggleStatus');
                    Route::delete('/{user}', 'destroy')->name('destroy');
                });

            // Admin Application Approval/Rejection
            Route::get('/applications', [ApplicationController::class, 'indexAdmin'])->name('applications.index');
            Route::get('/applications/{application}', [ApplicationController::class, 'showAdmin'])->name('applications.show');
            Route::post('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
            Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
        });

});