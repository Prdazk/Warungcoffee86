<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');      // nama menu
            $table->integer('harga');    // harga menu
            $table->string('kategori');  // kategori menu
            $table->string('status');    // status (tersedia/habis)
            $table->string('gambar')->nullable(); // gambar menu
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
