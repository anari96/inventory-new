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
        'jenis_item_id',
        'nama_item',
        'harga_item',
        'biaya_item',
        'tipe_jual',
        'sku',
        'lacak_stok',
        'stok',
        'stok_gudang',
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
        if($this->harga_item == 0){
            return 0;
        }
        return ($this->biaya_item - $this->harga_item) / $this->harga_item * 100;
    }

    public function retur_penjualan()
    {
        return $this->hasMany(DetailReturPenjualan::class);
    }

    public function getTotalReturPenjualanAttribute()
    {
        $retur_penjualan = $this->retur_penjualan;
        $total = 0;

        foreach($retur_penjualan as $data){
            $total += $data->qty;
        }

        return $total;
    }
}
