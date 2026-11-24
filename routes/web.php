<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenyewaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

Route::middleware(['auth', 'role:Admin,Kasir'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('penyewa', PenyewaController::class)->except(['show']);
});