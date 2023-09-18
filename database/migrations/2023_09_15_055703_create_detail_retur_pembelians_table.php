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
        Schema::create('detail_retur_pembelians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('retur_penjualan_id');
            $table->string('nama_item');
            $table->unsignedBigInteger('item_id');
            $table->integer('qty');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_retur_pembelians');
    }
};
