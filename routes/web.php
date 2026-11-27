<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeralatanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kategori', KategoriController::class)->except('show');
Route::resource('peralatan', PeralatanController::class)->except('show');