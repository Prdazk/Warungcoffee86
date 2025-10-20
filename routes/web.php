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

// Halaman utama user (dashboard)
Route::get('/', function () {
    return view('user.dashboard', [
        'menus' => Menu::all(),
    ]);
})->name('user.dashboard');

// Simpan reservasi dari form user
Route::post('/user/reservasi/store', [UserReservasiController::class, 'store'])
    ->name('user.reservasi.store');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // --- Autentikasi Admin ---
    Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // --- Semua route berikut butuh login ---
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('/beranda', [DashboardController::class, 'index'])->name('admin.beranda');

        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */
        Route::prefix('menu')->name('admin.menu.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');           // daftar menu
            Route::get('/create', [MenuController::class, 'create'])->name('create');   // form tambah menu
            Route::post('/store', [MenuController::class, 'store'])->name('store');     // simpan menu
            Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');    // edit menu
            Route::put('/{id}', [MenuController::class, 'update'])->name('update');     // update menu
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('destroy'); // hapus menu
        });

        /*
        |--------------------------------------------------------------------------
        | RESERVASI
        |--------------------------------------------------------------------------
        */
        Route::prefix('reservasi')->name('admin.reservasi.')->group(function () {
            Route::get('/', [AdminReservasiController::class, 'index'])->name('index');
            Route::delete('/{id}', [AdminReservasiController::class, 'destroy'])->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | DATA ADMIN (SUPERADMIN)
        |--------------------------------------------------------------------------
        */
      Route::prefix('data-admin')->name('admin.dataAdmin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');             // daftar admin
            Route::get('/create', [AdminController::class, 'create'])->name('create');     // form tambah admin
            Route::post('/store', [AdminController::class, 'store'])->name('store');       // simpan admin
            Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');   // edit admin
            Route::put('/{admin}', [AdminController::class, 'update'])->name('update');    // update admin
            Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');// hapus admin

            // Kelola Password (tidak perlu ulang prefix 'data-admin')
          Route::get('/{admin}/password', [AdminController::class, 'editPassword'])->name('password');
            Route::put('/{admin}/password', [AdminController::class, 'updatePassword'])->name('updatePassword');

        });
    });
});
