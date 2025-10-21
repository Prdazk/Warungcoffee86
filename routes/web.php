<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ReservasiController as UserReservasiController;

/*
|--------------------------------------------------------------------------
| ROUTE USER
|--------------------------------------------------------------------------
*/

// Halaman utama user
Route::get('/', function () {
    return view('user.dashboard', [
        'menus' => Menu::all(),
    ]);
})->name('user.dashboard');

// Simpan reservasi
Route::post('/user/reservasi/store', [UserReservasiController::class, 'store'])
    ->name('user.reservasi.store');


/*
|--------------------------------------------------------------------------
| ROUTE ADMIN & SUPERADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ===============================
    // 🔐 LOGIN TANPA MIDDLEWARE
    // ===============================
    Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    // ===============================
    // 🔒 HANYA ADMIN YANG SUDAH LOGIN
    // ===============================
    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/beranda', [DashboardController::class, 'index'])->name('beranda');

        // ===============================
        // MENU
        // ===============================
        Route::prefix('menu')->name('menu.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::post('/store', [MenuController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MenuController::class, 'update'])->name('update');
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('destroy');
        });

        // ===============================
        // RESERVASI
        // ===============================
        Route::prefix('reservasi')->name('reservasi.')->group(function () {
            Route::get('/', [AdminReservasiController::class, 'index'])->name('index');
            Route::delete('/{id}', [AdminReservasiController::class, 'destroy'])->name('destroy');
        });

        // ===============================
        // DATA ADMIN (KHUSUS SUPERADMIN)
        // ===============================
        Route::middleware('checkRole:superadmin')->prefix('data-admin')->name('dataAdmin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('/create', [AdminController::class, 'create'])->name('create');
            Route::post('/store', [AdminController::class, 'store'])->name('store');
            Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
            Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
            Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');

            Route::get('/{admin}/password', [AdminController::class, 'editPassword'])->name('password');
            Route::put('/{admin}/password', [AdminController::class, 'updatePassword'])->name('updatePassword');
        });
    });
});
