<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teknisi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "nama_teknisi",
        "telp_teknisi"
    ];

    public function service()
    {
        return $this->hasMany(Service::class);
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($teknisi) {
             $teknisi->service()->each(function($service) {
                $service->delete();
             });
        });
    }
}
