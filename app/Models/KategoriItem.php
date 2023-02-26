<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'nama_kategori',
        'warna_kategori',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }
}
