<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengguna_id',
        'kategori_item_id',
        'nama_item',
        'harga_item',
        'biaya_item',
        'tipe_jual',
        'sku',
        'barcode',
        'lacak_stok',
        'stok',
        'warna_item',
        'bentuk_item',
        'gambar_item',
    ];

    public function kategoriItem()
    {
        return $this->belongsTo(KategoriItem::class)->withDefault([
            'nama_kategori'=>'Tidak Ada'
        ]);
    }

    public function getMarginHargaAttribute()
    {
        //margin harga dalam persen
        return ($this->biaya_item - $this->harga_item) / $this->harga_item * 100;
    }
}
