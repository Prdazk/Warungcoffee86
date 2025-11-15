<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis';

    protected $fillable = [
        'nama',
        'jumlah_orang',
        'meja_id',
        'tanggal',
        'jam',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'string', // tidak di-cast ke time agar format tetap utuh
    ];

    protected $attributes = [
        'status' => 'baru', // default status awal reservasi
    ];

    /**
     * Relasi ke tabel mejas
     */
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }

    /**
     * Scope: Ambil reservasi aktif hari ini
     */
    public function scopeAktif($query)
    {
        return $query->whereDate('tanggal', now()->toDateString())
                     ->where('status', 'Dipesan');
    }
}
