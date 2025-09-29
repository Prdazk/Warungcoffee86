<?php

use Illuminate\Support\Facades\Route;
use App\Models\Menu;

// Halaman user dengan data menu
Route::get('/', fn() => view('user.dashboard', ['menus' => \App\Models\Menu::all()]))->name('user.dashboard');


// halaman admin
Route::get('/admin', fn() => view('admin.login'));
Route::post('/admin/login', fn() => redirect('/admin/beranda'))->name('admin.login');
Route::get('/admin/beranda', fn() => view('admin.beranda'))->name('admin.beranda');
Route::get('/admin/tambah', fn() => view('admin.tambah'))->name('admin.menu.tambah');
Route::post('/admin/menu/store', fn() => redirect()->back())->name('admin.menu.store');
Route::get('/admin/logout', fn() => redirect('/admin'))->name('admin.logout');
