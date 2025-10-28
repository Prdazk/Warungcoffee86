<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'mejas';

    protected $fillable = [
        'nama_meja',
        'kapasitas',
        'status_meja', // Kosong, Dipesan, Terisi
    ];

    /**
     * Relasi: satu meja bisa punya banyak reservasi
     */
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'meja_id');
    }

    /**
     * Scope: hanya meja yang tersedia
     */
    public function scopeTersedia($query)
    {
        return $query->where('status_meja', 'Kosong');
    }
}
