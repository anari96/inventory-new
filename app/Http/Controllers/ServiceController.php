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

use DateInterval;
use DatePeriod;
use DateTime;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
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

        $datas = Service::whereBetween("created_at", [$begin->format('Y-m-d'), $end->format('Y-m-d')])->paginate(10);

        return response()->view("service.index", compact("datas","periodeTanggals","periode"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $teknisi = Teknisi::all();
        $pelanggan = Pelanggan::all();

        $data = [
            "teknisi" => $teknisi,
            "pelanggan" => $pelanggan,
        ];

        return response()->view("service.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->jumlah[0]);

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama,
            'telp_pelanggan' => $request->kontak,
            'alamat_pelanggan' => $request->alamat
        ]);

        $pelanggan->save();

        $service = Service::create([
            'pelanggan_id' => $pelanggan->id,
            'pengguna_id' => $request->pengguna_id,
            'teknisi_id' => $request->teknisi_id,
            'no_service' => $request->no_service,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'imei1' => $request->imei1,
            'imei2' => $request->imei2,
            'kerusakan' => $request->kerusakan,
            'deskripsi' => $request->deskripsi,
            'kelengkapan' => $request->kelengkapan,
            'tanggal' => date("Y-m-d"),
            'garansi' => $request->garansi,
            'biaya' => str_replace("Rp ","",str_replace(".","",$request->biaya)),

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $data = Service::find($id);
        $detail = DetailService::where("service_id", $id)->get();
        $teknisi = Teknisi::all();

        $data = [
            "data" => $data,
            "detail" => $detail,
            "teknisi" => $teknisi
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

        $data->update([
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'imei1' => $request->imei1,
            'imei2' => $request->imei2,
            'kerusakan' => $request->kerusakan,
            'deskripsi' => $request->deskripsi,
            'kelengkapan' => $request->kelengkapan,
            'tanggal' => date("Y-m-d"),
            'garansi' => $request->garansi,
            'biaya' => str_replace("Rp ","",str_replace(".","",$request->biaya)),

            //status: pending, dikerjakan, selesai, batal, diambil, refund
            'status' => "pending"
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
        $datas = Service::where('status','selesai')->paginate(10);
        return response()->view('service.garansi', compact('datas'));
    }

    public function proses(Request $request, string $id)
    {
        $service = Service::find($id);
        $service->update([
            "status" => $request->status,
        ]);

        return redirect(route("service.list"));
    }
}
