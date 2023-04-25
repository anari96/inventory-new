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


}
