<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengembalian_id',
        'detail_penjualan_id',
        'qty',
    ];

    protected $appends = ['total'];

    public function detail_penjualan()
    {
        return $this->belongsTo(DetailPenjualan::class);
    }


    public function getTotalAttribute()
    {
        return $this->detail_penjualan->harga_item * $this->qty;
    }
}
