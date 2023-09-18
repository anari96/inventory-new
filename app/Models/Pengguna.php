<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama_pengguna',
        'email',
        'password',
        'nama_usaha',
        'api_token',
        'level_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

}
