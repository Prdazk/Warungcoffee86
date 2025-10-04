<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\MenuController;

// Halaman user dengan data menu
Route::get('/', fn() => view('user.dashboard', ['menus' => \App\Models\Menu::all()]))->name('user.dashboard');

// Halaman login admin
Route::get('/admin', fn() => view('admin.login'))->name('admin.login.form');
Route::post('/admin/login', fn() => redirect('/admin/beranda'))->name('admin.login');
Route::get('/admin/beranda', [MenuController::class, 'index'])->name('admin.beranda');
Route::get('/admin/tambah', fn() => view('admin.tambah'))->name('admin.menu.tambah');
Route::post('/admin/menu/store', [MenuController::class, 'store'])->name('admin.menu.store');
Route::get('/admin/logout', fn() => redirect('/admin'))->name('admin.logout');
Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('admin.menu.edit');
Route::put('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])->name('admin.menu.hapus');