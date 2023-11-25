<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Service;
use Illuminate\Http\Request;

use DateInterval;
use DatePeriod;
use DateTime;

class LaporanController extends Controller
{
    public function index()
    {
        return response()->view("laporan.index");
    }

    public function penjualan(Request $request)
    {
        $penjualan = new Penjualan;

        $pendapatan = 0;
        // $data =

        foreach($penjualan->get() as $penjualan)
        {
            $pendapatan += $penjualan->total;
        }

        $data = $penjualan->paginate(10);
        $data = [
            "datas" => $data,
            "pendapatan" => $pendapatan
        ];
        return response()->view("laporan.penjualan", $data);
    }
    public function service(Request $request)
    {
        try{
            // dd( url()->current());
            // dd( '?'.http_build_query($request->query()));
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

            $datas = new Service;

            if(!isset($request->sorting_order)){
                $sorting_order = "asc";
            }
            if(isset($request->sorting_order)){
                if($request->sorting_order == "desc"){
                    $sorting_order = "asc";
                }else if($request->sorting_order == "asc"){
                    $sorting_order = "desc";
                }
            }


            if(isset($begin) && isset($end)){
                $datas = $datas->tanggal($begin,$end);
            }

            if(isset($request->status)){
                $datas = $datas->where("status",$request->status);
            }

            if(isset($request->nama_pelanggan)){
                $datas = $datas->cari($request->nama_pelanggan);
            }

            if(isset($request->order)){
                $order = $request->order;
                if($request->order == "nama_pelanggan"){
                    $datas = $datas->orderBy(Pelanggan::select("nama_pelanggan")
                        ->whereColumn('pelanggans.id','services.pelanggan_id')
                    , $sorting_order);
                }else{
                    $datas = $datas->orderBy($request->order, $sorting_order);
                }
            }else{

                $datas = $datas->orderBy("created_at", "desc");
            }

            $datas = $datas->paginate(10);

            $data = [
                "request" => $request,
                "datas" => $datas,
                "periodeTanggals" => $periodeTanggals,
                "periode" => $periode,
                "sorting_order" => $sorting_order,
            ];

            return response()->view("laporan.service", $data);
        }catch(\Throwable $th){

            return redirect()->route('laporan.service');
        }
    }

    public function pembelian(Request $request)
    {

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


        $datas = Pembelian::whereBetween("created_at", [$begin->format('Y-m-d'), $end->format('Y-m-d')])->paginate(10);
        $data = [
            'datas' => $datas,
            "periode" => $periode,
            "periodeTanggals" => $periodeTanggals
        ];
        return response()->view('laporan.pembelian', $data);
    }
}
