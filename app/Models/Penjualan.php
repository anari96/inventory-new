<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{   
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'nomor_nota',
        'tanggal_penjualan',
    
    ];

    protected $appends = ['total'];

    public function detail_penjualan(){
        return $this->hasMany(DetailPenjualan::class);
    }

    public function getTotalAttribute()
    {
        return $this->detail_penjualan->sum(function($detail){
            return $detail->harga_item * $detail->qty;
        });
    }
}
