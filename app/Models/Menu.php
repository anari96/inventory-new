<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
       "nama_menu",
    ];

    public function scopeSearchMenu($query, $menu, $menu_action){
        return $query->where("nama_menu",$menu)->where("aksi_menu", $menu_action);
    }
}
