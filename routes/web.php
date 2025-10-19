<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\AdminController; // <- tambahkan ini
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
            Route::get('/', [MenuController::class, 'index'])->name('index');          
            Route::get('/create', [MenuController::class, 'create'])->name('create');   
            Route::post('/store', [MenuController::class, 'store'])->name('store');     
            Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');    
            Route::put('/{id}', [MenuController::class, 'update'])->name('update');     
            Route::delete('/{id}', [MenuController::class, 'destroy'])->name('hapus');  
        });

        // --- Reservasi ---
        Route::prefix('reservasi')->group(function () {
            Route::get('/', [AdminReservasiController::class, 'index'])->name('admin.reservasi.index');
            Route::delete('/{id}', [AdminReservasiController::class, 'destroy'])->name('admin.reservasi.destroy');
        });

        // --- Data Admin (superadmin only) ---
        Route::prefix('data-admin')->name('admin.dataAdmin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');               // Daftar admin
            Route::get('/create', [AdminController::class, 'create'])->name('create');       // Form tambah admin
            Route::post('/store', [AdminController::class, 'store'])->name('store');         // Simpan admin baru
            Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');        // Form edit admin
            Route::put('/{id}', [AdminController::class, 'update'])->name('update');         // Update admin
            Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');    // Hapus admin
        });

    });
});
