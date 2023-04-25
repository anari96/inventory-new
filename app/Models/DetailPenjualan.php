<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        $total = ($this->harga_item * $this->qty);
        $totalDiskon = 0;
        foreach ($this->diskons as $key => $diskon) {
            if($diskon->jenis_diskon == "persen"){
                $totalDiskon += $total * $diskon->nilai_diskon / 100;
            } else {
                $totalDiskon += $diskon->nilai_diskon;
            }
        }
        return $total  - $totalDiskon;
    }

    public function detail_pengembalians()
    {
        return $this->hasMany(DetailPengembalian::class);
    }

    public function diskons()
    {
        return $this->belongsToMany(Diskon::class,'diskon_detail_penjualans','detail_penjualan_id','diskon_id');
    }
}
