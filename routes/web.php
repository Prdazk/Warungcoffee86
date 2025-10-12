<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\ReservasiController as UserReservasiController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\AdminAuthController;

// ===========================
// HALAMAN USER
// ===========================
Route::get('/', function () {
    return view('user.dashboard', [
        'menus' => Menu::all()
    ]);
})->name('user.dashboard');

// Simpan data reservasi dari user
Route::post('/user/reservasi/store', [UserReservasiController::class, 'store'])
    ->name('user.reservasi.store');

// ===========================
// HALAMAN ADMIN
// ===========================
Route::prefix('admin')->group(function () {

    // Form login admin
    Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Admin dashboard & protected routes
    Route::middleware('admin.auth')->group(function () {

        // Dashboard / Beranda admin
        Route::get('/beranda', [MenuController::class, 'index'])->name('admin.beranda');

        // =======================
        // CRUD MENU ADMIN
        // =======================
        Route::prefix('menu')->group(function () {
            Route::post('/store', [MenuController::class, 'store'])->name('admin.menu.store');
            Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('admin.menu.edit');
            Route::put('/update/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('admin.menu.hapus');
        });

        // =======================
        // CRUD RESERVASI ADMIN
        // =======================
        Route::prefix('reservasi')->group(function () {
            Route::get('/', [AdminReservasiController::class, 'index'])->name('admin.reservasi.index');
            Route::delete('/{id}', [AdminReservasiController::class, 'destroy'])->name('admin.reservasi.hapus');
        });

    });
});
