<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScholarshipApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApplicationApiController; 

// Public Routes (No token needed)
Route::get('/scholarships', [ScholarshipApiController::class, 'index']);

// Protected Routes (Require Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/scholarships', [ScholarshipApiController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/admin/approve-provider/{user}', [AuthController::class, 'approveProvider']);
Route::post('/admin/reject-provider/{user}', [AuthController::class, 'rejectProvider']);
Route::post('/scholarships/{scholarship}/apply', [ApplicationApiController::class, 'apply']);
    Route::post('/applications/{application}/status', [ApplicationApiController::class, 'updateStatus']);
    Route::get('/admin/users', [AuthController::class, 'indexUsers']);
    Route::patch('/admin/users/{user}/toggle', [AuthController::class, 'toggleUserStatus']);
    Route::delete('/admin/users/{user}', [AuthController::class, 'destroyUser']);
});

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
