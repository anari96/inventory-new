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

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->detail_penjualan as $detail) {
            $total += $detail->total;
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
