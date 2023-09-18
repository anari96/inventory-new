<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            "nama_pelanggan" => "Umum",
            "alamat_pelanggan" => "Umum",
            "telp_pelanggan" => "08xxxxxxx",
            "pengguna_id" => 1
        ]);
    }
}
