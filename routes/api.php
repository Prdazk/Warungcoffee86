<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\ReservasiController;

// API ambil meja tersedia
Route::get('/available-meja', [MejaController::class, 'availableMeja']);

// API simpan reservasi user
Route::post('/reservasi', [ReservasiController::class, 'store']);
