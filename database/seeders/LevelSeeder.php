<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Level::create([
            'nama_level' => 'Admin'
        ]);
        Level::create([
            'nama_level' => 'Kasir'
        ]);
        Level::create([
            'nama_level' => 'Sales'
        ]);
        Level::create([
            'nama_level' => 'Teknisi'
        ]);
        Level::create([
            'nama_level' => 'Gudang'
        ]);
    }
}
