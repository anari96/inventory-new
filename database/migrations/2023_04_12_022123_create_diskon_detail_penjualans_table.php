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
        Schema::create('diskon_detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diskon_id')->index();
            $table->unsignedBigInteger('detail_penjualan_id')->index();
            $table->integer('nilai_diskon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskon_detail_penjualans');
    }
};
