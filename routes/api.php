<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ReservasiController;

// === RESERVASI USER ===
Route::prefix('user/reservasi')->group(function () {
    Route::get('/available-meja', [ReservasiController::class, 'availableMeja']);
    Route::post('/store', [ReservasiController::class, 'store']);
});
