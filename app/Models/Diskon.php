<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'nama_diskon',
        'jenis_diskon',
        'nilai_diskon'
    ];
}
