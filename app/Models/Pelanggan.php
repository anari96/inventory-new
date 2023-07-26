<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $fillable = [
      "nama_pelanggan",
      "email_pelanggan",
      "telp_pelanggan",
      "alamat_pelanggan"
    ];
}
