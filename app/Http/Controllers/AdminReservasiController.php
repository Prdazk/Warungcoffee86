<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class AdminReservasiController extends Controller
{
    // Menampilkan semua reservasi
    public function index()
    {
        $reservasis = Reservasi::latest()->get();
        return view('admin.reservasi', compact('reservasis'));
    }

    // Menghapus reservasi
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();

        return redirect()->route('admin.reservasi')
                         ->with('success', 'Reservasi berhasil dihapus!');
    }
}
