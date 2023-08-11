<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable =[
        "supplier_id",
        "tanggal_pembelian",
        "nomor_nota",
        "pengguna_id",
    ];


    public function detail_pembelian(){
        return $this->hasMany(DetailPembelian::class);
    }
}
