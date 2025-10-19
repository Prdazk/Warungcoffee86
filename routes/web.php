<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
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

    // --- Halaman Admin (yang butuh login) ---
    Route::middleware('admin.auth')->group(function () {

        // Dashboard Admin
        Route::get('/beranda', [DashboardController::class, 'index'])->name('admin.beranda');

      // --- Menu ---
        Route::prefix('menu')->name('admin.menu.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');          // Menampilkan daftar menu
            Route::get('/create', [MenuController::class, 'create'])->name('create');   // Form tambah menu
            Route::post('/store', [MenuController::class, 'store'])->name('store');     // Simpan menu baru
            Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');    // Form edit menu
            Route::put('/{id}', [MenuController::class, 'update'])->name('update');     // Update menu
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('hapus');  // Hapus menu
        });


        // --- Reservasi ---
       Route::prefix('reservasi')->group(function () {
        Route::get('/', [AdminReservasiController::class, 'index'])->name('admin.reservasi.index');
        Route::delete('/{id}', [AdminReservasiController::class, 'destroy'])->name('admin.reservasi.destroy');
        });
    });
});
