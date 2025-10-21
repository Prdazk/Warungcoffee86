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
        'jabatan',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
