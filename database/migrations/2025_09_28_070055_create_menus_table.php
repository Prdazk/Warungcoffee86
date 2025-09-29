<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('menus', function (Blueprint $table) {
            $table->id(); // id menu
            $table->string('name'); // nama menu
            $table->text('description')->nullable(); // deskripsi menu
            $table->decimal('price', 8, 2); // harga
            $table->string('image')->nullable(); // gambar menu
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('menus');
    }
};
