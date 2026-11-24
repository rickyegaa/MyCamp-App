<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PengembalianController;

Route::get('/', function () {
    return redirect('/penyewaan');
});

// Modul Transaksi Penyewaan (Riki Ega)
Route::get('/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan.index');
Route::post('/penyewaan', [PenyewaanController::class, 'store'])->name('penyewaan.store');

// Modul Pengembalian & Denda (Riki Ega)
Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');

// Fallback Logout agar tombol Keluar di navbar tetap aman saat demo
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/penyewaan');
})->name('logout');