<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPenjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        "pengguna_id",
        "no_penjualan",
        "pelanggan_id",
        "keterangan",
        "sale_id",
        "tanggal",
    ];

    public function detail()
    {
        return $this->hasMany(DetailReturPenjualan::class);
    }
}
