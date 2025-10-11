<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // Guard yang digunakan
    protected $guard = 'admin';

    // Kolom yang bisa diisi
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Kolom yang disembunyikan (biasanya password dan remember_token)
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
