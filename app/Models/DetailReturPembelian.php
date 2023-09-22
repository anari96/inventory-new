<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReturPembelian extends Model
{
    use HasFactory;


    protected $fillable = [
        "nama_item",
        "qty",
        "retur_pembelian_id",
        "item_id"
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
