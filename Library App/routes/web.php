<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;

Route::resource('/buku', BukuController::class);
Route::resource('/kategori', KategoriController::class);
Route::resource('/anggota', AnggotaController::class);
Route::resource('/peminjaman', PeminjamanController::class);

Route::get('/test', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
