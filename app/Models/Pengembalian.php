<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'nomor_nota',
        'tanggal_pengembalian',
    ];


    public function detail_pengembalians()
    {
        return $this->hasMany(DetailPengembalian::class);
    }

    

}
