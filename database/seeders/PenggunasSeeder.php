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
            'nama_pengguna' => 'User',
            'nama_usaha' => 'User',
            'email' => 'user@email.com',
            'password' => Hash::make('passworduser321!'),
            'usaha_id' => 2,
            'level_id' => 1,
        ]);
    }
}
