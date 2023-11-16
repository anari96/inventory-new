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
        "biaya",
        "uang_bayar",
        "status_pembayaran"
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

    public function pembayaran_service()
    {
        return $this->hasMany(PembayaranService::class);
    }

    public function getGrandTotalAttribute()
    {
        return $this->biaya + $this->total_sparepart;
    }

    public function getTotalPembayaranServiceAttribute()
    {
        $total = 0;
        foreach ($this->pembayaran_service as $pembayaran_service) {
            $total += $pembayaran_service->uang_bayar;
        }
        return $total+$this->uang_bayar;
    }

    public function getStatusLunasAttribute()
    {
        if($this->biaya != 0){
            if($this->total_pembayaran_service < $this->grand_total){
                return "Belum Lunas";
            }else if($this->total_pembayaran_service >= $this->grand_total){
                return "Sudah Lunas";
            }
        }else if($this->biaya == 0){
           return "Belum Ditanggapi";
        }
    }

    public function getStatusPembayaranLabelAttribute()
    {
        $status_pembayaran = "";
        switch ($this->status_pembayaran){
            case "belum_ditanggapi":
                $status_pembayaran =  "Belum Ditanggapi";
                break;
            case "belum_lunas":
                $status_pembayaran = "Belum Lunas";
                break;
            case "lunas":
                $status_pembayaran = "Lunas";
                break;
        }

        return $status_pembayaran;
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

    public function scopeCari($query,$name){
        return $query->whereHas("pelanggan", function($q) use($name){
            $q->where("nama_pelanggan", "like", "%".$name."%");
        });
    }

    public function scopeTanggal($query,$begin,$end){
        return $query->whereBetween("created_at", [$begin->format('Y-m-d'), $end->format('Y-m-d')]);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function($service){
            $service->detail()->each(function($detail){
                $detail->delete();
            });
        });
    }
}
