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
        "uang_bayar",
        "metode_bayar",
        "pengguna_id",
    ];


    public function detail_pembelian(){
        return $this->hasMany(DetailPembelian::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->detail_pembelian as $detail) {
            $total += $detail->qty * $detail->harga_item;
        }
        return $total;
    }

    public function pembayaran_hutang(){
        return $this->hasMany(PembayaranHutang::class);
    }

    public function getTotalPembayaranHutangAttribute()
    {
        $total = 0;
        foreach ($this->pembayaran_hutang as $pembayaran_hutang) {
            $total += $pembayaran_hutang->uang_bayar;
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

    public function getStatusLunasAttribute()
    {
        if($this->total_pembayaran_hutang < $this->total){
            return false;
        }else if($this->total_pembayaran_hutang >= $this->total){
            return true;
        }
    }
}
