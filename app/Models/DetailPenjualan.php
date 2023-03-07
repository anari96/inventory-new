<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penjualan_id',
        'qty',
        'item_id',
        'harga_item',
        'nama_item'
    ];

    protected $appends = ['total'];

    public function getTotalAttribute()
    {
        return $this->harga_item * $this->qty;
    }

    public function detail_pengembalians()
    {
        return $this->hasMany(DetailPengembalian::class);
    }
}
