<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        "pengguna_id",
        "no_pembelian",
        "pelanggan_id",
        "keterangan",
        "tanggal",
    ];

    public function detail()
    {
        return $this->hasMany(DetailReturPembelian::class);
    }
}
