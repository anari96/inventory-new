<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaUmumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengguna::create([
            'nama_pengguna' => 'Umum',
            'nama_usaha' => 'Umum',
            'email' => 'umum@email.com',
            'password' => Hash::make('passwordumum321'),
            'usaha_id' => 0,
        ]);
    }
}
