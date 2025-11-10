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
        'menus' => \App\Models\Menu::all(),
    ]);
})->name('user.dashboard');

// Simpan reservasi dari user (POST)
Route::post('/user/reservasi/store', [UserReservasiController::class, 'store'])
    ->name('user.reservasi.store');

// Ambil daftar meja tersedia untuk AJAX refresh
Route::get('/user/reservasi/available-meja', [UserReservasiController::class, 'availableMeja']) 
    ->name('user.reservasi.availableMeja');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN & SUPERADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 🔐 LOGIN TANPA MIDDLEWARE
    |--------------------------------------------------------------------------
    */
    Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    /*
    |--------------------------------------------------------------------------
    | 🔒 HANYA ADMIN YANG SUDAH LOGIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/beranda', [DashboardController::class, 'index'])->name('beranda');

        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */
        Route::prefix('menu')->name('menu.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::post('/store', [MenuController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MenuController::class, 'update'])->name('update');
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('destroy');
        });

            /*
        |--------------------------------------------------------------------------
        | RESERVASI + KELOLA MEJA
        |--------------------------------------------------------------------------
        */
        Route::prefix('reservasi')->name('reservasi.')->group(function () {

            // Halaman utama reservasi
            Route::get('/', [AdminReservasiController::class, 'index'])->name('index');

            // Hapus reservasi
            Route::delete('/{id}', [AdminReservasiController::class, 'destroy'])->name('destroy');

            // Edit / Update reservasi
            Route::put('/{id}', [AdminReservasiController::class, 'update'])->name('update');

            // Ambil data reservasi terbaru (AJAX polling)
            Route::get('/latest', [AdminReservasiController::class, 'latest'])->name('latest');

            // KELOLA MEJA
            Route::prefix('meja')->name('meja.')->group(function () {
                Route::post('/store', [AdminReservasiController::class, 'storeMeja'])->name('store');
                Route::put('/{id}', [AdminReservasiController::class, 'updateMeja'])->name('update');
                Route::delete('/{id}', [AdminReservasiController::class, 'destroyMeja'])->name('destroy');
            });
        });

        /*
        |--------------------------------------------------------------------------
        | DATA ADMIN (KHUSUS SUPERADMIN)
        |--------------------------------------------------------------------------
        */
        Route::middleware('checkRole:superadmin')
            ->prefix('data-admin')
            ->name('dataAdmin.')
            ->group(function () {
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