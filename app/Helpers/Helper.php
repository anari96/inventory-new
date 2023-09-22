<?php
namespace App\Helpers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Http\Request;

class Helper{
    public static function hakAkses($nama_menu,$aksi){
        $cek = Role::whereHas('Menu',function ($q) use($nama_menu,$aksi)
        {
            $q->where('nama_menu', $nama_menu)
                ->where('aksi_menu', $aksi);
        })->where('id',Auth::user()->level->id)->count();
        if ( $cek > 0 ) {
            return true;
        } else {
            return false;
        }
    }
}
