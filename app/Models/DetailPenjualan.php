<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class DetailPenjualan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'penjualan_id',
        'qty',
        'diskon',
        'item_id',
        'harga_item',
        'nama_item'
    ];

    protected $appends = ['total'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function getTotalAttribute()
    {
        $total = (($this->harga_diskon) * $this->qty);

        return $total;
    }

    public function detail_pengembalians()
    {
        return $this->hasMany(DetailPengembalian::class);
    }

    public function getHargaDiskonAttribute()
    {
        return $this->harga_item - $this->diskon;
    }
}
