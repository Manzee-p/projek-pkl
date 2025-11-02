<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PrioritasController;
use App\Http\Controllers\TiketStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Login manual
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// ✅ Register manual
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ✅ Google login
Route::get('/auth-google-redirect', [AuthController::class, 'google_redirect'])->name('google.redirect');
Route::get('/auth-google-callback', [AuthController::class, 'google_callback'])->name('google.callback');

// ✅ Akses user biasa
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ✅ CRUD Kategori
    Route::resource('kategori', KategoriController::class);
    
    // ✅ CRUD Event
    Route::resource('event', EventController::class);
    
    // ✅ CRUD Prioritas
    Route::resource('prioritas', PrioritasController::class);
    
    // ✅ CRUD Status Tiket
    Route::resource('admin/status', TiketStatusController::class)
         ->except(['show'])
         ->names([
             'index'   => 'admin.status.index',
             'create'  => 'admin.status.create',
             'store'   => 'admin.status.store',
             'edit'    => 'admin.status.edit',
             'update'  => 'admin.status.update',
             'destroy' => 'admin.status.destroy',
         ]);
});