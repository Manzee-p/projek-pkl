<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// route login manual (opsional, karena Auth::routes() sudah buat otomatis)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/auth-google-redirect', [AuthController::class, 'google_redirect']);
Route::get('/auth-google-callback', [AuthController::class, 'google_callback']);

Route::group(['middleware' => ['auth', 'check_role:customer']], function () {
    Route::get('/home', [HomeController::class, 'index']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth', 'check_role:admin']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::get('/logout', [AuthController::class, 'logout']);