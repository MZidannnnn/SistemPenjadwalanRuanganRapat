<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'create'])->name('login');

// Route untuk memproses form login
Route::post('/login', [AuthController::class, 'store']);
