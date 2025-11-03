<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PrioritasController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TiketStatusController;
use Illuminate\Support\Facades\Route;

// ============================
// 🔹 Halaman Awal (Welcome)
// ============================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ============================
// 🔹 Auth (Login & Register)
// ============================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// 🔹 Google Login
Route::get('/auth-google-redirect', [AuthController::class, 'google_redirect'])->name('google.redirect');
Route::get('/auth-google-callback', [AuthController::class, 'google_callback'])->name('google.callback');

// ============================
// 🔒 Hanya untuk User yang Login
// ============================
Route::middleware('auth')->group(function () {

    // Halaman Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ============================
    // 🔒 Hanya untuk Admin
    // ============================
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

        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/create', fn() => view('admin.report.create'))->name('create');
        Route::post('/', [ReportController::class, 'store'])->name('store');
        Route::get('/{id}/edit', fn($id) => view('admin.report.edit', ['report' => \App\Models\Report::findOrFail($id)]))->name('edit');
        Route::put('/{id}', [ReportController::class, 'update'])->name('update');
        Route::delete('/{id}', [ReportController::class, 'destroy'])->name('destroy');
    });

    // ============================
    // 🎫 Tiket Routes (User)
    // ============================
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

        // Update tiket
        Route::put('/{tiket_id}', [TiketController::class, 'update'])->name('tiket.update');

        // Hapus tiket
        Route::delete('/{tiket_id}', [TiketController::class, 'destroy'])->name('tiket.destroy');
    });
});