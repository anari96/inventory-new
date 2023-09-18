<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama_jenis",
        "kategori_item_id",
    ];

    public function kategori_item()
    {
        return $this->belongsTo(KategoriItem::class);
    }
}
