<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- GUEST ROUTES ---
// Rute untuk pengguna yang belum login.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
});

// --- AUTHENTICATED ROUTES ---
// Rute untuk pengguna yang sudah login.
Route::middleware('auth')->group(function () {
    // Redirect dari halaman utama ke dashboard jika sudah login
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::middleware('role:SKPD')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
    Route::middleware('role:admin')->group(function () {
        Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
        Route::delete('/ruangan/{ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');
        Route::put('/ruangan/{ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');

        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');

    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::delete('/pemesanan/{pemesanan}', [PemesananController::class, 'destroy'])->name('pemesanan.destroy');
    Route::put('/pemesanan/{pemesanan}', [PemesananController::class, 'update'])->name('pemesanan.update');
    Route::get('/pemesanan/by-date/{date}', [PemesananController::class, 'getByDate'])->name('pemesanan.byDate');
    Route::get('/pemesanan/scheduled-dates/{year}/{month}', [PemesananController::class, 'getScheduledDatesInMonth'])->name('pemesanan.scheduledDates');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
