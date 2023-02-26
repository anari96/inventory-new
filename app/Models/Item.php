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
}
