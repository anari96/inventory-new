<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiGudang extends Model
{
    use HasFactory;

    protected $fillable = [
        "pengguna_id",
        "keterangan",
        "tanggal",
        "toko",
    ];

    public function detail()
    {
        return $this->hasMany(DetailTransaksiGudang::class);
    }
}
