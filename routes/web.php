<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservasiController;
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
Route::post('/user/reservasi/store', [ReservasiController::class, 'store'])
    ->name('user.reservasi.store');

// ===========================
// HALAMAN ADMIN
// ===========================
Route::prefix('admin')->group(function () {

    // FORM LOGIN
    Route::get('/', [AdminAuthController::class, 'showLoginForm'])
        ->name('admin.login.form');

    // PROSES LOGIN
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.submit');

    // LOGOUT (POST)
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout');

    // HALAMAN ADMIN PROTECTED
    Route::middleware('admin.auth')->group(function () {

        // Dashboard / Beranda admin
        Route::get('/beranda', [MenuController::class, 'index'])
            ->name('admin.beranda');

        // =======================
        // CRUD MENU
        // =======================
        Route::prefix('menu')->group(function () {
            Route::post('/store', [MenuController::class, 'store'])->name('admin.menu.store');
            Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('admin.menu.edit');
            Route::put('/update/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('admin.menu.hapus');
        });

        // =======================
        // CRUD RESERVASI
        // =======================
        Route::prefix('reservasi')->group(function () {
            Route::delete('/{id}', [ReservasiController::class, 'destroy'])->name('admin.reservasi.hapus');
        });
    });
});
