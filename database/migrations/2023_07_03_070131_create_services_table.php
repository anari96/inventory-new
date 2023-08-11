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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('garansi');
            $table->integer('pelanggan_id');
            $table->string('merk');
            $table->string('tipe');
            $table->string('imei1')->nullable();
            $table->string('imei2')->nullable();
            $table->string('kerusakan');
            $table->string('deskripsi');
            $table->string('kelengkapan');
            $table->date('tanggal');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
