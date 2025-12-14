<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScholarshipApiController; // Import Controller API

// URL ini otomatis akan jadi: /api/scholarships
Route::get('/scholarships', [ScholarshipApiController::class, 'index']);