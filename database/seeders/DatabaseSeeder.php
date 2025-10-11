<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua data lama dulu (optional)
        Admin::truncate();

        // Tambahkan akun admin utama
        Admin::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);

        // (Optional) Tambahkan akun developer juga, kalau mau
        Admin::create([
            'email' => 'developer@gmail.com',
            'password' => Hash::make('dev123'),
            'role' => 'developer',
        ]);
    }
}
