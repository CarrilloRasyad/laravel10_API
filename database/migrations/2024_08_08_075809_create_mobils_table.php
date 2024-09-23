<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_mobil', ['MPV', 'SUV', 'Hybrid']);
            $table->string('nama_mobil');
            $table->enum('merk', ['Toyota', 'Mazda', 'Honda', 'Mini Cooper']);
            $table->string('nopol');
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
