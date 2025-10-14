<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Request;

Route::get('/cek-user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:sanctum');

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

Route::middleware(['auth:sanctum','check_role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);       // list semua role
    Route::post('/roles', [RoleController::class, 'store']);      // buat role baru
    Route::get('/roles/{id}', [RoleController::class, 'show']);   // lihat detail role
    Route::put('/roles/{id}', [RoleController::class, 'update']); // update role
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']); // hapus role
});

// Semua ini hanya bisa diakses Admin
Route::middleware(['auth:sanctum','check_role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index']);
    Route::post('/reports', [ReportController::class, 'store']);
});
