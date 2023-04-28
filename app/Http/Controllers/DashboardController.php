<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\KategoriItem;
use App\Models\Pengembalian;
use App\Models\Pengguna;
use App\Models\Penjualan;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {   
        $user = auth()->user();
        if(auth()->guard('penggunas')->check()){
            
            // $penjualanKotor = Penjualan::where('pengguna_id', $user->id)->get()->sum('total');
            // $pengembalian = Pengembalian::where('pengguna_id', $user->id)->get()->sum('total');
            // $diskon = DetailPenjualan::whereHas('diskons')->whereHas('penjualan', function($query) use ($user){
            //     $query->where('pengguna_id', $user->id);
            // })->get()->sum('total');
            // $penjualanBersih = $penjualanKotor - $diskon - $pengembalian;
            $penjualanKotor = 0;
            $pengembalian = 0;
            $diskon = 0;
            $penjualanBersih = 0;
            $labaKotor = 0;
            
            // this will default to a time of 00:00:00
            $begin = new DateTime('-1 month');
            $end = new DateTime();
            $periode = [
                $begin->format('d/m/Y'),
                $end->format('d/m/Y'),
            ];
        
            if(request()->periode){
                $periode = explode(" - ",request()->periode);
                $begin = DateTime::createFromFormat('d/m/Y', $periode[0]);
                $end = DateTime::createFromFormat('d/m/Y', $periode[1]);
                
            }
            $end->modify('+1 day');

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval, $end);
            $periodeTanggals = [];
            foreach($daterange as $date) {

                $periodeTanggals[] = strftime("%d-%b", strtotime($date->format("Y-m-d")));
            }
            
            $detail_penjualans = DetailPenjualan::whereHas('penjualan', function($query) use ($user){
                $query->where('pengguna_id', $user->id);
            })->whereBetween('created_at',[$begin,$end]);
            if(request()->karaywan_id && request()->karaywan_id != ""){
                $detail_penjualans = $detail_penjualans->whereHas('penjualan', function($query){
                    $query->where('pengguna_id', request()->karaywan_id);
                });
            }
            if(request()->kategori_item_id && request()->kategori_item_id != ""){
                $detail_penjualans = $detail_penjualans->whereHas('item', function($query){
                    $query->where('kategori_item_id', request()->kategori_item_id);
                });
            }
            $detail_penjualans = $detail_penjualans->get();
            foreach ($detail_penjualans as $dp) {
                $hargaBeli = $dp->item->biaya_item ?? 0;
                $total = ($dp->harga_item * $dp->qty);
                $totalDiskon = 0;
                foreach ($dp->diskons as $key => $_diskon) {
                    if($_diskon->jenis_diskon == "persen"){
                        $totalDiskon += $total * $_diskon->nilai_diskon / 100;
                    } else {
                        $totalDiskon += $_diskon->nilai_diskon;
                    }
                }
                $penjualanKotor += $total;
                $pengembalian += $dp->detail_pengembalians->sum('total');
                $diskon += $totalDiskon;
                $penjualanBersih += $total - $totalDiskon - $dp->detail_pengembalians->sum('total');
                $labaKotor += ($total - $totalDiskon - $dp->detail_pengembalians->sum('total'))-($hargaBeli * $dp->qty);
            }

            $charts = [
                'penjualanKotor' => [],
                'pengembalian' => [],
                'diskon' => [],
                'penjualanBersih' => [],
                'hargaPokok' => [],
                'labaKotor' => []
            ];
            foreach ($daterange as $key => $date) {
                $detail_penjualans = DetailPenjualan::whereHas('penjualan', function($query) use ($user){
                    $query->where('pengguna_id', $user->id);
                })->whereDate('created_at',$date->format('Y-m-d'));
                if(request()->karaywan_id && request()->karaywan_id != ""){
                    $detail_penjualans = $detail_penjualans->whereHas('penjualan', function($query){
                        $query->where('pengguna_id', request()->karaywan_id);
                    });
                }
                if(request()->kategori_item_id && request()->kategori_item_id != ""){
                    $detail_penjualans = $detail_penjualans->whereHas('item', function($query){
                        $query->where('kategori_item_id', request()->kategori_item_id);
                    });
                }
                $detail_penjualans = $detail_penjualans->get();
                $g_penjualanKotor = 0;
                $g_pengembalian = 0;
                $g_diskon = 0;
                $g_penjualanBersih = 0;
                $g_hargaPokok = 0;
                $g_labaKotor = 0;
                foreach ($detail_penjualans as $dp) {
                    $hargaBeli = $dp->item->biaya_item ?? 0;
                    $total = ($dp->harga_item * $dp->qty);
                    $totalDiskon = 0;
                    foreach ($dp->diskons as $key => $_diskon) {
                        if($_diskon->jenis_diskon == "persen"){
                            $totalDiskon += $total * $_diskon->nilai_diskon / 100;
                        } else {
                            $totalDiskon += $_diskon->nilai_diskon;
                        }
                    }
                    $g_penjualanKotor += $total;
                    $g_pengembalian += $dp->detail_pengembalians->sum('total');
                    $g_diskon += $totalDiskon;
                    $g_penjualanBersih += $total - $totalDiskon - $dp->detail_pengembalians->sum('total');
                    $g_hargaPokok += ($hargaBeli * $dp->qty);
                    $g_labaKotor += ($total - $totalDiskon - $dp->detail_pengembalians->sum('total'))-($hargaBeli * $dp->qty);
                }

                $charts['penjualanKotor'][] = $g_penjualanKotor;
                $charts['pengembalian'][] = $g_pengembalian;
                $charts['diskon'][] = $g_diskon;
                $charts['penjualanBersih'][] = $g_penjualanBersih;
                $charts['hargaPokok'][] = $g_hargaPokok;
                $charts['labaKotor'][] = $g_labaKotor;
            }
            
            $karyawans = Pengguna::where('usaha_id', $user->usaha_id)->get();
            $kategoris = KategoriItem::whereHas('pengguna', function($query) use ($user){
                $query->where('usaha_id', $user->usaha_id);
            })->get();

            $data = [
                'penjualanKotor' => $penjualanKotor,
                'pengembalian' => $pengembalian,
                'diskon' => $diskon,
                'penjualanBersih' => $penjualanBersih,
                'labaKotor' => $labaKotor,
                'periodeTanggals'=>$periodeTanggals,
                'charts'=>$charts,
                'periode'=>$periode,
                'karyawans'=>$karyawans,
                'kategoris'=>$kategoris
            ];
            return view('dashboard.pengguna',$data);
        } else {
            return view('dashboard.user');
        }
    }
}
