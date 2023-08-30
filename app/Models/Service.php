<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "garansi",
        "pelanggan_id",
        "pengguna_id",
        "teknisi_id",
        "no_service",
        "merk",
        "tipe",
        "kerusakan",
        "deskripsi",
        "kelengkapan",
        "status",
        "imei1",
        "imei2",
        "tanggal",
        "status",
        "biaya"
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailService::class);
    }

    public function getTotalSparepartAttribute()
    {
        $total = 0;

        foreach($this->detail as $d){
            $total += $d->sparepart->harga_item;
        }

        return $total;
    }

    public function getTotalSparepartTokoAttribute()
    {
        $total = 0;

        foreach($this->detail as $d){
            if($d->sparepart->kategoriItem->nama_kategori == "Sparepart")
            {
                $total += $d->sparepart->harga_item;
            }
        }

        return $total;
    }


    public function getTotalSparepartLuarAttribute()
    {
        $total = 0;

        foreach($this->detail as $d){
            if($d->sparepart->kategoriItem->nama_kategori == "Sparepart Luar")
            {
                $total += $d->sparepart->harga_item;
            }
        }

        return $total;
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function($service){
            $service->detail_penjualan()->each(function($detail){
                $detail->delete();
            });
        });
    }
}
