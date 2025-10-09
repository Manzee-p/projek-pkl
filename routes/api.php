<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Login & Register
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Google OAuth
Route::get('/auth/google/redirect', [AuthController::class, 'google_redirect']);
Route::get('/auth/google/callback', [AuthController::class, 'google_callback']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route untuk user role: customer
Route::middleware(['auth:sanctum', 'check_role:customer'])->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
});

// Route untuk user role: admin
Route::middleware(['auth:sanctum', 'check_role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
