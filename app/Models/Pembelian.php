<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        "supplier_id",
        "tanggal_pembelian",
        "nomor_nota",
        "pengguna_id",
    ];


    public function detail_pembelian(){
        return $this->hasMany(DetailPembelian::class);
    }

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->detail_pembelian as $detail) {
            $total += $detail->qty * $detail->harga_item;
        }
        return $total;
    }


    public function getJumlahBarangAttribute()
    {
        $total = 0;
        foreach ($this->detail_pembelian as $detail) {
            $total += $detail->qty;
        }
        return $total;
    }
}
