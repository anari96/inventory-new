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
        ],[
            'nama_level' => 'Teknisi'
        ],[
            'nama_level' => 'Kasir'
        ],[
            'nama_level' => 'Sales'
        ]);
    }
}
