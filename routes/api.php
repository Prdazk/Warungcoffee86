<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ReservasiController;

Route::get('/available-meja', [ReservasiController::class, 'availableMeja']);
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('user.reservasi.store');