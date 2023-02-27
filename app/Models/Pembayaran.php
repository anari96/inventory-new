<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'penjualan_id',
        'pengguna_id',
        'jenis',
        'jumlah_bayar',
        'tanggal_bayar'
    ];
}
