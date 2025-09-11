<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'index'])->name('login');

// Route untuk memproses logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk memproses form login
Route::post('/login', [AuthController::class, 'store']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth') // Middleware 'auth' memastikan hanya user terautentikasi yang bisa masuk
    ->name('dashboard');