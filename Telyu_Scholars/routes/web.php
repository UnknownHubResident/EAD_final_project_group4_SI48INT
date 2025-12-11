<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;     // <-- Required Import
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\AdminMiddleware; // <-- Required Import


// ======================================================================
// 1. PUBLIC ROUTES (Login, Register)
// ======================================================================
Route::get('/', function () {
    return redirect()->route('register'); // Or redirect to 'login'
});

Route::get('/register', [RegisterController::class, 'ShowRegisFrom'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


// ======================================================================
// 2. PROTECTED ROUTES (Requires User to be LOGGED IN)
// ======================================================================
Route::middleware(['auth'])->group(function () {
    
    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 

    // Unified Dashboard (Routes all roles/statuses via DashboardController logic)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    // ------------------------------------------------------------------
    // 3. ADMIN ONLY ROUTES (Requires Auth AND 'admin' role)
    // ------------------------------------------------------------------
    Route::middleware(['auth', AdminMiddleware::class]) // You can list all required middleware here
    ->prefix('admin') 
    ->name('admin.') 
    ->group(function () {
        
        // This is the action route for approving a pending provider
        // URL: /admin/approve/{user} | Name: admin.approve
        Route::post('/approve/{user}', [AdminController::class, 'approveProvider'])->name('approve'); 
        
        // ------------------------------------------------------------------
        // FIX APPLIED HERE:
        // ------------------------------------------------------------------
        
        // The URL is simply 'pending' because 'admin' is handled by prefix()
        // The name is simply 'pending' because 'admin.' is handled by name()
        // Middleware is applied by the group
        Route::get('/pending', [AdminController::class, 'showPendingProviders'])
            ->name('pending'); // FIX: Name is now just 'pending' (resolved to 'admin.pending')

        // Existing routes:
        Route::post('/approve/{user}', [AdminController::class, 'approveProvider'])->name('approve'); 
        Route::get('/pending', [AdminController::class, 'showPendingProviders'])->name('pending'); 

        // --- NEW USER MANAGEMENT ROUTES ---

        // 1. View all users (Index)
        // URL: /admin/users | Name: admin.users
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');

        // 2. View the Edit User form (Show/Edit)
        // URL: /admin/users/{user}/edit | Name: admin.users.edit
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');

        // 3. Update the user details (Update)
        // URL: /admin/users/{user} | Name: admin.users.update
        Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');

        // 4. Delete a user (Destroy)
        // URL: /admin/users/{user} | Name: admin.users.destroy
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');

        // 5. Toggle account status (Activate/Deactivate)
        // URL: /admin/users/{user}/toggle | Name: admin.users.toggle
        Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleActiveStatus'])->name('users.toggle'); 
        
    });
});