<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReturPenjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        "nama_item",
        "qty",
        "retur_penjualan_id",
        "item_id"
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
