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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id')->index();
            $table->unsignedBigInteger('kategori_item_id')->index();
            $table->string('nama_item',100);
            $table->integer('harga_item',false);
            $table->string('sku',50);
            $table->string('barcode',100)->nullable();
            $table->boolean('lacak_stok')->default(false);
            $table->double('stok')->default(0);
            $table->enum('tipe_stok',['satuan','berat'])->nullable();
            $table->string('warna_item',100)->nullable();
            $table->string('gambar_item',150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
