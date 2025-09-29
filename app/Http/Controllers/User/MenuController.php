<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index() {
        $menus = Menu::all(); // Ambil semua data menu
        return view('user.dashboard', compact('menus')); // Kirim ke view
    }
}
