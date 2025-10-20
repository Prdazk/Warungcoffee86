<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            // Nama lengkap admin
            $table->string('nama')->nullable();

            // Email unik untuk login
            $table->string('email')->unique();

            // Password terenkripsi
            $table->string('password');

            // Jabatan opsional
            $table->string('jabatan')->nullable();

            // Role sesuai kebutuhan sistem
            $table->enum('role', ['superadmin', 'admin'])->default('admin');

            // Token remember (untuk session Laravel)
            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
