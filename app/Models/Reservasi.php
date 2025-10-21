<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'reservasis';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'nama',
        'jumlah_orang',
        'pilihan_meja',
        'tanggal',
        'jam',
        'catatan',
        'status', // tambahkan status supaya bisa langsung di-set saat create
    ];
}
