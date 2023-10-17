<?php
namespace App\Helpers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Helper{
    public static function hakAkses($nama_menu,$aksi){
        $cek = Role::whereHas('Menu',function ($q) use($nama_menu,$aksi)
        {
            $q->where('nama_menu', $nama_menu)
                ->where('aksi_menu', $aksi);
        })->where('id',Auth::user()->role->id)->count();
        if ( $cek > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public static function hakAksesUser($user_id,$nama_menu,$aksi){
        $cek = Role::whereHas('Menu',function ($q) use($nama_menu,$aksi)
        {
            $q->where('nama_menu', $nama_menu)
                ->where('aksi_menu', $aksi);
        })->where('id', $user_id)->count();
        if ( $cek > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendWa($number, $message)
    {
        $key='7e10303d8e75d503ef83ab381ac95f692a476a9766c51090';
        $url='http://116.203.92.59/api/async_send_message';
        $data = array(
            "phone_no"=> $number,
            "key"       =>$key,
            "message"   =>$message,
        // "url"        =>$img_url,
        );
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;

    }
}
