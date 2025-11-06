<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PrioritasController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TiketStatusController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    // Jika sudah login, redirect ke home
    if ((Auth::check())) {
        return redirect()->route('home');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    // Jika sudah login, redirect ke home
    if ((Auth::check())) {
        return redirect()->route('home');
    }
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// 🔹 Google Login
Route::get('/auth-google-redirect', [AuthController::class, 'google_redirect'])->name('google.redirect');
Route::get('/auth-google-callback', [AuthController::class, 'google_callback'])->name('google.callback');


// Protected routes - butuh login
Route::middleware('auth')->group(function () {

    // Halaman Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->middleware('isAdmin')->group(function () {
        // CRUD Kategori
        Route::resource('kategori', KategoriController::class);

        // CRUD Event
        Route::resource('event', EventController::class);

        // CRUD Prioritas
        Route::resource('prioritas', PrioritasController::class);

        // CRUD Status Tiket
        Route::resource('status', TiketStatusController::class)
            ->except(['show'])
            ->names([
                'index'   => 'admin.status.index',
                'create'  => 'admin.status.create',
                'store'   => 'admin.status.store',
                'edit'    => 'admin.status.edit',
                'update'  => 'admin.status.update',
                'destroy' => 'admin.status.destroy',
            ]);


            // ✅ Admin Tiket Routes
            Route::get('/tiket', [TiketController::class, 'adminIndex'])->name('admin.tiket.index');
            
            Route::resource('tiket', TiketController::class)->except(['index'])->names([
                'create'  => 'admin.tiket.create',
                'store'   => 'admin.tiket.store',
                'show'    => 'admin.tiket.show',
                'edit'    => 'admin.tiket.edit',
                'update'  => 'admin.tiket.update',
                'destroy' => 'admin.tiket.destroy',
            ]);
        Route::get('report', [ReportController::class, 'index'])->name('admin.report.index');
        Route::get('report/create', [ReportController::class, 'create'])->name('admin.report.create');
        Route::post('report', [ReportController::class, 'store'])->name('admin.report.store');
        Route::get('report/{id}/edit', [ReportController::class, 'edit'])->name('admin.report.edit');
        Route::put('report/{id}', [ReportController::class, 'update'])->name('admin.report.update');
        Route::delete('report/{id}', [ReportController::class, 'destroy'])->name('admin.report.destroy');
    });

    // Tiket routes - untuk user yang sudah login
    Route::prefix('tiket')->group(function () {

        // Daftar tiket
        Route::get('/', [TiketController::class, 'index'])->name('tiket.index');

        // Form buat tiket
        Route::get('/create', function () {
            $events    = \App\Models\Event::all();
            $kategoris = \App\Models\Kategori::all();
            $prioritas = \App\Models\Prioritas::all();
            $statuses  = \App\Models\TiketStatus::all();
            $tikets    = \App\Models\Tiket::with('status', 'kategori', 'event', 'prioritas')->get();

            return view('tiket.create', compact('events', 'kategoris', 'prioritas', 'statuses', 'tikets'));
        })->name('tiket.create');

        // Simpan tiket
        Route::post('/', [TiketController::class, 'store'])->name('tiket.store');

        // Detail tiket
        Route::get('/{tiket_id}', [TiketController::class, 'show'])->name('tiket.show');

        // Form edit tiket
        Route::get('/{tiket_id}/edit', [TiketController::class, 'edit'])->name('tiket.edit');

        // Update tiket
        Route::put('/{tiket_id}', [TiketController::class, 'update'])->name('tiket.update');

        // Hapus tiket
        Route::delete('/{tiket_id}', [TiketController::class, 'destroy'])->name('tiket.destroy');
    });

    // Report routes - untuk user biasa
        Route::prefix('report')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('report.index');
            Route::get('/create', [ReportController::class, 'create'])->name('report.create');
            Route::post('/', [ReportController::class, 'store'])->name('report.store');
            Route::get('/{id}/edit', [ReportController::class, 'edit'])->name('report.edit');
            Route::put('/{id}', [ReportController::class, 'update'])->name('report.update');
            Route::delete('/{id}', [ReportController::class, 'destroy'])->name('report.destroy');
        });
    
});
