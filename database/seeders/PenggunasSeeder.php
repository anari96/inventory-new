<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengguna::create([
            'nama_pengguna' => 'Admin',
            'nama_usaha' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('passworduser321!'),
            'level_id' => 1,
        ]);
    }
}
