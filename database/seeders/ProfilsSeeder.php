<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profil::create([
            'nama' => 'Toko Toko',
            'alamat' => 'Jl. Jalan',
            'kontak' => 'No. Telepon : 080808080808',
            'keterangan' => 'Harap Cek barang terlebih dahulu',
            'logo1' => "Logo1.jpg",
            'logo2' => "Logo2.jpg",
        ]);
    }
}
