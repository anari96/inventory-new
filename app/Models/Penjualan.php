<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pengguna_id',
        'nomor_nota',
        'uang_bayar',
        'metode_bayar',
        'pelanggan_id',
        'tanggal_penjualan',

    ];

    public function pengguna(){
        return $this->belongsTo(Pengguna::class);
    }

    public function pelanggan(){
            return $this->belongsTo(Pelanggan::class);
    }

    public function detail_penjualan(){
        return $this->hasMany(DetailPenjualan::class);
    }

    public function pembayaran_piutang(){
        return $this->hasMany(PembayaranPiutang::class);
    }

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->detail_penjualan as $detail) {
            $total += $detail->total;
        }
        return $total;
    }


    public function getTotalPembayaranPiutangAttribute()
    {
        $total = 0;
        foreach ($this->pembayaran_piutang as $pembayaran_piutang) {
            $total += $pembayaran_piutang->uang_bayar;
        }
        return $total;
    }

    public function getJumlahBarangAttribute()
    {
        $total = 0;
        foreach ($this->detail_penjualan as $detail) {
            $total += $detail->qty;
        }
        return $total;
    }

    public function getStatusLunasAttribute()
    {
        if($this->total_pembayaran_piutang < $this->total){
            return false;
        }else if($this->total_pembayaran_piutang >= $this->total){
            return true;
        }
    }

    // public function scopeLunas($query)
    // {
    //     // return $this->where()
    // }

    public static function boot()
    {
        parent::boot();
        self::deleting(function($penjualan){
            $penjualan->detail_penjualan()->each(function($detail_penjualan){
                $detail_penjualan->delete();
            });
        });
    }

}
