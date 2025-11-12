<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminData;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        AdminData::truncate();

        AdminData::create([
            'nama' => 'Superadmin Utama',
            'email' => 'superadmin@gmail.com',
            'role' => 'superadmin',
            'no_hp' => '081234567890',
            'password' => Hash::make('semangatku'),
        ]);

        AdminData::create([
            'nama' => 'Admin Standar',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'no_hp' => '089876543210',
            'password' => Hash::make('admin123'),
        ]);
    }
}
