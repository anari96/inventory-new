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
        Schema::create('kategori_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id')->index();
            $table->string('nama_kategori',100);
            $table->string('warna_kategori',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_items');
    }
};
