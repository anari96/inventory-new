<?php

namespace Database\Seeders;

use App\Models\KategoriItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriItem::create([
            "pengguna_id" => 1,
            "nama_kategori" => 'Umum',
        ],[
            "pengguna_id" => 1,
            "nama_kategori" => 'Sparepart Toko',
        ],[

            "pengguna_id" => 1,
            "nama_kategori" => 'Sparepart Luar',
        ]);
    }
}
