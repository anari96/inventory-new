<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailService extends Model
{
    use HasFactory;

    protected $fillable = [
        "service_id",
        "sparepart_id",
        "item_id",
        "jumlah"
    ];

    public function sparepart()
    {
        return $this->belongsTo(Item::class,'item_id');
    }
}
