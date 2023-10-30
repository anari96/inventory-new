<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\DetailService;
use App\Models\Teknisi;
use App\Models\Sparepart;
use App\Models\Item;
use App\Models\Pengguna;

use DateInterval;
use DatePeriod;
use DateTime;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $list_kerusakan = [
            ["mati_total","Mati Total"],["nand_emmc","NAND/EMMC"],["not_charging","Not Charging"],["no_signal","No Signal"],["battery","Battery"],["lcd_ts"," LCD/TS"],["mic_audio","Mic Audio"],["software_bypass","Software/Bypass"],["dll","Dll"]
        ];
    private $list_kelengkapan = [
            ["simcard","Simcard"],["memory_card","Memory Card"],["back_casing","Back Casing"]
        ];

    public function index(Request $request)
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

            return response()->view("service.index", compact("request","datas","periodeTanggals","periode","sorting_order"));
        }catch(\Throwable $th){

            return redirect()->route('service.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $list_kerusakan = $this->list_kerusakan;
        $list_kelengkapan = $this->list_kelengkapan;

        $teknisi = Teknisi::all();
        $pelanggan = Pelanggan::all();

        $data = [
            "teknisi" => $teknisi,
            "pelanggan" => $pelanggan,
            "list_kelengkapan" => $list_kelengkapan,
            "list_kerusakan" => $list_kerusakan,
        ];

        return response()->view("service.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->pelanggan_id == null){
            $pelanggan = Pelanggan::create([
                'nama_pelanggan' => $request->nama,
                'telp_pelanggan' => $request->kontak,
                'alamat_pelanggan' => $request->alamat,
                'pengguna_id' => auth()->user()->id
            ]);
            $pelanggan->save();
        }


        if($request->pelanggan_id != null){
            $pelanggan_id = $request->pelanggan_id;
        }else if($request->pelanggan_id == null){
            $pelanggan_id = $pelanggan->id;
        }

        $kerusakan = (isset($request->kerusakan)) ? implode(",",$request->kerusakan) : " ";
        $kelengkapan = (isset($request->kelengkapan)) ? implode(",",$request->kelengkapan) : " ";

        $service = Service::create([
            'pelanggan_id' => $pelanggan_id,
            'pengguna_id' => auth()->user()->id,
            'teknisi_id' => $request->teknisi_id,
            'no_service' => $request->no_service,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'imei1' => $request->imei1,
            'imei2' => $request->imei2,
            'kerusakan' => $kerusakan,
            'deskripsi' => $request->deskripsi,
            'kelengkapan' => $kerusakan,
            'tanggal' => date("Y-m-d"),
            'garansi' => $request->garansi,
            'biaya' => str_replace("Rp ","",str_replace(".","",$request->biaya)),
            'uang_bayar' => $request->uang_bayar,
            //status: pending, dikerjakan, selesai, batal, diambil, refund
            'status' => "pending"
        ]);

        $service->save();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailService::create([
                        "service_id" => $service->id,
                        "item_id" => $request->id[$i],
                        "jumlah" => $request->jumlah[$i],
                    ]);



                    $item->update([
                        "stok" => $item->stok - $request->jumlah[$i],
                    ]);
                    // $sparepart = Sparepart::find($request->id[$i]);
                    // $sparepart->update([
                    //     "stok" => $sparepart->stok - $request->jumlah[$i]
                    // ]);
            }
        }

        return redirect(route("service.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $datas = Service::find($id);
        $data = [
            'datas' => $datas,
        ];
        return response()->view('service.nota', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $list_kerusakan = $this->list_kerusakan;
        $list_kelengkapan = $this->list_kelengkapan;
        $datas = Service::find($id);
        $detail = DetailService::where("service_id", $id)->get();
        $teknisi = Teknisi::all();
        $pelanggan = Pelanggan::all();
        $kelengkapan = explode(",",$datas->kelengkapan);
        $kerusakan = explode(",",$datas->kerusakan);

        $data = [
            "datas" => $datas,
            "detail" => $detail,
            "teknisi" => $teknisi,
            "pelanggan" => $pelanggan,
            "list_kelengkapan" => $list_kelengkapan,
            "list_kerusakan" => $list_kerusakan,
            "kelengkapan" => $kelengkapan,
            "kerusakan" => $kerusakan
        ];

        // dd($detail);
        return response()->view("service.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = Service::find($id);
        $old_detail = DetailService::where("service_id", $id);

        // foreach($old_detail as $od)
        // {
        //     $old_sparepart = Sparepart::find($od->sparepart_id);
        //     $old_sparepart->update([
        //         "stok" => $old_sparepart + $od->jumlah,
        //     ]);
        // }


        foreach($old_detail->get() as $o){
            $item_old = Item::find($o->item_id);
            $item_old->update([
                "stok" => $item_old->stok + $o->qty
            ]);
        }

        $old_detail->delete();

        if($request->pelanggan_id == null){
            $pelanggan = Pelanggan::create([
                'nama_pelanggan' => $request->nama,
                'telp_pelanggan' => $request->kontak,
                'alamat_pelanggan' => $request->alamat,
                'pengguna_id' => auth()->user()->id,
            ]);
            $pelanggan->save();
        }

        if($request->pelanggan_id != null){
            $pelanggan_id = $request->pelanggan_id;
        }else if($request->pelanggan_id == null){
            $pelanggan_id = $pelanggan->id;
        }

        $kerusakan = (isset($request->kerusakan)) ? implode(",",$request->kerusakan) : " ";
        $kelengkapan = (isset($request->kelengkapan)) ? implode(",",$request->kelengkapan) : " ";

        $data->update([
            'merk' => $request->merk,
            'pelanggan_id' => $pelanggan_id,
            'tipe' => $request->tipe,
            'teknisi_id' => $request->teknisi_id,
            'imei1' => $request->imei1,
            'imei2' => $request->imei2,
            'kerusakan' => $kerusakan,
            'deskripsi' => $request->deskripsi,
            'kelengkapan' => $kelengkapan,
            'tanggal' => date("Y-m-d"),
            'garansi' => $request->garansi,
            'biaya' => str_replace("Rp ","",str_replace(".","",$request->biaya)),
            'uang_bayar' => $request->uang_bayar,
            //status: pending, dikerjakan, selesai, batal, diambil, refund
        ]);


        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailService::create([
                        "service_id" => $data->id,
                        "item_id" => $request->id[$i],
                        "jumlah" => $request->jumlah[$i],
                    ]);

                    $item->update([
                        "stok" => $item->stok - $request->jumlah[$i],
                    ]);
                    // $sparepart = Sparepart::find($request->id[$i]);
                    // $sparepart->update([
                    //     "stok" => $sparepart->stok - $request->jumlah[$i]
                    // ]);
            }
        }


        return redirect(route("service.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = Service::find($id);
            $data->delete();
            DB::commit();
            return redirect()->route('service.index')->with('success','Item berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('service.index')->with('error','Item gagal dihapus');
        }
    }

    public function dashboard()
    {
        $service_pending = Service::where('status', "pending")->count();
        $service_pending_harian = Service::where('status', "pending")->whereDate("created_at", date("Y-m-d"))->count();

        $service_dikerjakan = Service::where('status', "dikerjakan")->count();
        $service_dikerjakan_harian = Service::where('status', "dikerjakan")->whereDate("updated_at", date("Y-m-d"))->count();

        $service_selesai = Service::where('status', "selesai")->count();
        $service_selesai_harian = Service::where('status', "selesai")->whereDate("updated_at", date("Y-m-d"))->count();

        return response()->view('service.dashboard', compact("service_pending","service_dikerjakan","service_selesai","service_pending_harian","service_dikerjakan_harian","service_selesai_harian"));
    }

    public function list(Request $request)
    {
        $status = $request->get('status') != null ? $request->get('status') : "pending";
        $datas = Service::where('status', $status)->paginate(10);
        return response()->view('service.list', compact('datas','status'));
    }

    public function list_terpakai()
    {
        $service = Service::whereMonth("created_at", date("m"))->get();

        $totalSparepartToko = 0;
        $totalSparepartLuar = 0;

        foreach($service as $s){
            $totalSparepartToko += $s->total_sparepart_toko;
            $totalSparepartLuar += $s->total_sparepart_luar;
        }

        $datas = Service::whereMonth("created_at", date("m"))->paginate(10);

        return response()->view('service.list_terpakai', compact("datas","totalSparepartLuar","totalSparepartToko"));
    }
    public function kas(Request $request)
    {
        $status = $request->get('status') != null ? $request->get('status') : "pending";

        if($status == "selesai" || $status == "diambil"){
            $datas = Service::whereIn("status", ["selesai","diambil"]);
        }else if ($status != "selesai" || $status != "diambil"){
            $datas = Service::whereNotIn("status", ["selesai","diambil"]);
        }

        $jumlah = $datas->get();

        $jumlahTotal = 0;

        foreach($jumlah as $j){
            $jumlahTotal += $j->total_sparepart;
        }

        $datas = $datas->paginate(10);

        return response()->view('service.kas', compact("datas","status","jumlahTotal"));
    }
    public function garansi()
    {
        $datas = Service::where('garansi','1')->paginate(10);
        return response()->view('service.garansi', compact('datas'));
    }

    public function proses(Request $request, string $id)
    {
        $service = Service::find($id);
        $service->update([
            "status" => $request->status,
        ]);

        return redirect(route("service.index"));
    }

    public function guest()
    {
        $list_kerusakan = $this->list_kerusakan;
        $list_kelengkapan = $this->list_kelengkapan;
        $data = [
            "list_kerusakan" => $list_kerusakan,
            "list_kelengkapan" => $list_kelengkapan,
        ];
        return response()->view('service.guest', $data);
    }

    public function guest_store(Request $request)
    {
        DB::beginTransaction();
        try{

            $request->validate([
                "nama" => "string|required|max:255",
                "alamat" => "string|required|max:255",
                "kontak" => "string|required|max:255",
                "merk" => "string|required|max:255",
                "tipe" => "string|required|max:255",
                "imei1" => "string|max:15",
                "imei2" => "string|max:15",
            ]);

            $pengguna = Pengguna::where('nama_pengguna','like','%Umum%')->first();
            $teknisi = Teknisi::where('nama_teknisi','like','%Umum%')->first();
            $no_nota = "S-". date('Y')."".date('m')."".date('d')."".date("his");


            $pelanggan = Pelanggan::create([
                'nama_pelanggan' => $request->nama,
                'telp_pelanggan' => $request->kontak,
                'alamat_pelanggan' => $request->alamat,
                'pengguna_id' => $pengguna->id,
            ]);

            $pelanggan_id = $pelanggan->id;

            $pelanggan->save();

            $kerusakan = (isset($request->kerusakan)) ? implode(",",$request->kerusakan) : $request->kerusakan;
            $kelengkapan = (isset($request->kelengkapan)) ? implode(",",$request->kelengkapan) : $request->kelengkapan;

            $service = Service::create([
                'pelanggan_id' => $pelanggan_id,
                'pengguna_id' => $pengguna->id,
                'teknisi_id' => $teknisi->id,
                'no_service' => $no_nota,
                'merk' => $request->merk,
                'tipe' => $request->tipe,
                'imei1' => $request->imei1,
                'imei2' => $request->imei2,
                'kerusakan' => $kerusakan,
                'deskripsi' => $request->deskripsi,
                'kelengkapan' => $kelengkapan,
                'tanggal' => date("Y-m-d"),
                'garansi' => $request->garansi,
                'biaya' => 0,
                'uang_bayar' => 0,

                //status: pending, dikerjakan, selesai, batal, diambil, refund
                'status' => "pending"
            ]);

            $service->save();
            DB::commit();
            return redirect()->route('service.guest')->with('success','Pesan Berhasil Dikirim, Harap tunggu jawaban dari kami.');

        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('service.guest')->with('error','Harap Check kembali isi Form');
        }
    }

    public function guest_done()
    {
        return response()->view('service.guest_done');
    }
}
