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
      "email_pelanggan",
      "telp_pelanggan",
      "alamat_pelanggan"
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
        self::deleting(function($pelanggan) { // before delete() method call this
             $pelanggan->penjualan()->each(function($penjualan) {
                $penjualan->delete(); // <-- direct deletion
             });
             $pelanggan->service()->each(function($service) {
                $service->delete(); // <-- raise another deleting event on Post to delete comments
             });
             // do the rest of the cleanup...
        });
    }
}
