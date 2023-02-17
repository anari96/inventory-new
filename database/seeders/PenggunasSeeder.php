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
            'nama_pengguna' => 'Bagus',
            'nama_usaha' => 'RM.BAGUS',
            'email' => 'bagus@email.com',
            'password' => Hash::make('password'),
        ]);
    }
}
