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
        Schema::table('detail_retur_penjualans', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->after('nama_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_retur_penjualans', function (Blueprint $table) {
            $table->dropColumn('item_id');
        });
    }
};
