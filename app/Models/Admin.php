<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Guard yang digunakan untuk autentikasi admin.
     */
    protected $guard = 'admin';

    /**
     * Kolom yang dapat diisi mass-assignment.
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'jabatan',
        'role',
    ];

    /**
     * Kolom yang tidak akan ditampilkan saat model dikonversi ke array/json.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Enkripsi otomatis password saat disimpan.
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
