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
        'status_meja', 
    ];

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'meja_id');
    }

    public function scopeTersedia($query)
    {
        return $query->where('status_meja', 'Kosong');
    }
}
