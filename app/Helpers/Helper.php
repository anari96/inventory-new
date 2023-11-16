<?php
namespace App\Helpers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Log;
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

    public static function getMyIP()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    // User Log
    // Helper::addUserLog('Menambah Penjualan', $query->toArray());
    public static function addUserLog($action,$actionDetail = null,$ip = null)
    {
        if($ip == null){
            $ip = Helper::getMyIP();
        }

        Log::create([
            'action'=>$action,
            'action_detail'=>json_encode($actionDetail),
            'user_id'=>Auth::user()->id,
            'ip'=>$ip,
            'ip_detail'=>NULL
        ]);
    }
}
