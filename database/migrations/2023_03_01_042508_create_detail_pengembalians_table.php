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
        Schema::create('detail_pengembalians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengembalian_id')->index();
            $table->unsignedBigInteger('detail_penjualan_id')->index();
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalians');
    }
};
