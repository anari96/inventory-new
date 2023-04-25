<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'nomor_nota',
        'tanggal_pengembalian',
        'penjualan_id'
    ];


    public function detail_pengembalians()
    {
        return $this->hasMany(DetailPengembalian::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }


    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->detail_pengembalians as $detail) {
            $total += $detail->total;
        }
        return $total;
    }
    

}
