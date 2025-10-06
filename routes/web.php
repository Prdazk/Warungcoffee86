<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservasiController;

// 🧑‍🍳 HALAMAN USER
// Halaman utama user (tampilkan semua menu)
Route::get('/', function () {
    return view('user.dashboard', [
        'menus' => Menu::all()
    ]);
})->name('user.dashboard');

// Simpan data reservasi (user)
Route::post('/user/reservasi/store', [ReservasiController::class, 'store'])
    ->name('user.reservasi.store');

// 🔐 LOGIN ADMIN
Route::get('/admin', fn() => view('admin.login'))->name('admin.login.form');
Route::post('/admin/login', fn() => redirect()->route('admin.beranda'))
    ->name('admin.login');

// 🏠 BERANDA ADMIN
Route::get('/admin/beranda', [MenuController::class, 'index'])
    ->name('admin.beranda');

// 🍽️ CRUD MENU (ADMIN)
Route::post('/admin/menu/store', [MenuController::class, 'store'])
    ->name('admin.menu.store');
Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])
    ->name('admin.menu.edit');
Route::put('/admin/menu/update/{id}', [MenuController::class, 'update'])
    ->name('admin.menu.update');
Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])
    ->name('admin.menu.hapus');

// 📅 CRUD RESERVASI (ADMIN)
// Hapus reservasi (admin)
Route::delete('/admin/reservasi/{id}', [ReservasiController::class, 'destroy'])
    ->name('admin.reservasi.hapus');

// 🚪 LOGOUT ADMIN
Route::get('/admin/logout', fn() => redirect()->route('admin.login.form'))
    ->name('admin.logout');
