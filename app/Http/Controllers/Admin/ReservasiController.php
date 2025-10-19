<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    // tampilkan semua reservasi
    public function index()
    {
        $reservasis = Reservasi::latest()->get();
        return view('admin.reservasi.index', compact('reservasis'));
    }

    // hapus reservasi
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Reservasi berhasil dihapus!');
    }
}
