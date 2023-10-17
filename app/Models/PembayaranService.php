<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembayaranService extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
       "service_id",
       "uang_bayar",
    ];
}
