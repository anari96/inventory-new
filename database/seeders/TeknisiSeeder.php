<?php

namespace Database\Seeders;

use App\Models\Teknisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeknisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teknisi::create([
            'nama_teknisi' => 'Umum',
            'telp_teknisi' => '08xxxxxxxx',
        ]);
    }
}
