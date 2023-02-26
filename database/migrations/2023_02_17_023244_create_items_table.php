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
            $table->unsignedBigInteger('pengguna_id')->index();
            $table->unsignedBigInteger('kategori_item_id')->nullable()->index();
            $table->string('nama_item',100);
            $table->integer('biaya_item',false)->nullable();
            $table->integer('harga_item',false)->nullable();
            $table->enum('tipe_jual',['satuan','berat'])->nullable();
            $table->string('sku',50);
            $table->string('barcode',100)->nullable();
            $table->boolean('lacak_stok')->default(false);
            $table->double('stok')->nullable();
            
            $table->string('warna_item',100)->nullable();
            $table->integer('bentuk_item',false)->default(0);
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
