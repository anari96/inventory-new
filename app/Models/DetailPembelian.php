<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPembelian extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "pembelian_id",
        "item_id",
        "qty",
        "diskon",
        "harga_item"
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
