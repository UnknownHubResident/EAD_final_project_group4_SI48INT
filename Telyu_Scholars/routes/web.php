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


// ======================================================================
// 1. PUBLIC ROUTES (Login, Register, and Public Scholarship Listing)
// ======================================================================

//route after log in (for student
Route::get('/', function () {
    if (Auth::check()){
        return redirect()->route('dashboard');
    }
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
    // 2.A: STUDENT ONLY APPLICATION MANAGEMENT 
    // ------------------------------------------------------------------
    


 Route::controller(StudentApplicationController::class)
        ->prefix('student/applications')
        ->name('student.applications.') 
        ->group(function () {
            
            Route::get('/', 'index')->name('index'); 

            
            Route::get('/create/{scholarship}', 'create')->name('create'); 

            
            Route::post('/store/{scholarship}', 'store')->name('store');
        });
        
    // ------------------------------------------------------------------
    // 2.B: PROVIDER ONLY SCHOLARSHIP MANAGEMENT and applcation ammanment
    // ------------------------------------------------------------------
    Route::middleware([ProviderRole::class]) 
        ->prefix('provider')
        ->name('provider.')
        ->group(function () {
            Route::resource('scholarships', ProviderScholarshipController::class)
                ->except(['show']);

          Route::controller(ProviderApplicationController::class)
                ->prefix('applications')
                ->name('applications.')
                ->group(function () {
                    Route::get('/', 'index')->name('index'); 
                    Route::get('/{application}', 'show')->name('show'); 
                    
                    // Status Update Actions
                    Route::post('/{application}/approve', 'approve')->name('approve'); 
                    
                    // Reject Form & Action
                    Route::get('/{application}/reject/form', 'showRejectForm')->name('reject.form'); 
                    Route::post('/{application}/reject', 'reject')->name('reject'); 
                    
                    // Document Download
                    Route::get('/{application}/download/{documentType}', 'downloadDocument')->name('download');
                });
        });

      



    
    // ------------------------------------------------------------------
    // 3. ADMIN ONLY ROUTES (Requires Auth AND 'admin' role)
    // ------------------------------------------------------------------
    Route::middleware(['auth', AdminMiddleware::class]) 
        ->prefix('admin') 
        ->name('admin.') 
        ->group(function () {
            
            Route::post('/approve/{user}', [AdminController::class, 'approveProvider'])->name('approve'); 
           
            Route::get('/providers/{user}/reject/form', [AdminController::class, 'showRejectForm'])->name('reject.form'); 
            Route::post('/providers/{user}/reject', [AdminController::class, 'finalizeReject'])->name('reject.finalize');
            Route::post('/providers/{user}/unreject', [AdminController::class, 'unrejectProvider'])->name('unreject');

            Route::get('/pending', [AdminController::class, 'showPendingProviders'])->name('pending'); 

            
            Route::resource('scholarships', ProviderScholarshipController::class) 
                ->except(['show']);

         Route::controller(AdminUserController::class)->prefix('users')->name('users.')->group(function () {
         Route::get('/', 'index')->name('index'); 
         Route::get('/{user}', 'show')->name('show'); 
         Route::put('/{user}/toggle-status', 'toggleStatus')->name('toggleStatus'); 
         Route::delete('/{user}', 'destroy')->name('destroy'); 

         
        });       
    });

});