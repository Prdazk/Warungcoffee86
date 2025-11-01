<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminData extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_data';

    protected $fillable = [
        'nama',
        'email',
        'jabatan', // admin / superadmin
        'role',    // otomatis sama dengan jabatan
        'no_hp',
        'password',
        'status',  // 1 = aktif, 0 = nonaktif
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
