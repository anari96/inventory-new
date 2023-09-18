<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
      "nama_pelanggan",
      "telp_pelanggan",
      "alamat_pelanggan",
      "pengguna_id"
    ];


    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function service()
    {
        return $this->hasMany(Service::class);
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($pelanggan) {
             $pelanggan->penjualan()->each(function($penjualan) {
                $penjualan->delete();
             });
             $pelanggan->service()->each(function($service) {
                $service->delete();
             });
        });
    }
}
