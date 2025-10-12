<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;

class ReservasiController extends Controller
{
    // Tampilkan semua reservasi di dashboard admin
        public function index()
    {
        $reservasis = Reservasi::latest()->get();
        return view('admin.reservasi', compact('reservasis'));
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dihapus!');
    }

}
