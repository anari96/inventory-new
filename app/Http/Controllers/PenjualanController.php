<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Profil;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use DateInterval;
use DatePeriod;
use DateTime;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
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


        $datas = Penjualan::whereBetween("created_at", [$begin->format('Y-m-d'), $end->format('Y-m-d')])->paginate(10);
        $data = [
            'datas' => $datas,
            "periode" => $periode,
            "periodeTanggals" => $periodeTanggals
        ];
        return response()->view('penjualan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $pelanggans = Pelanggan::all();
        $datas = [
            "pelanggans" => $pelanggans,
        ];
        return response()->view('penjualan.create', $datas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
       $penjualan = Penjualan::create([
            "pelanggan_id" => $request->pelanggan_id,
            "tanggal_penjualan" => $request->tanggal,
            "nomor_nota" => $request->no_penjualan,
            "pengguna_id" => auth()->user()->id
        ]);

       $penjualan->save();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailPenjualan::create([
                        "penjualan_id" => $penjualan->id,
                        "item_id" => $request->id[$i],
                        "qty" => $request->jumlah[$i],
                        "diskon" => $request->diskon[$i],
                        "harga_item" => $item->harga_item,
                    ]);

                    $item->update([
                        "stok" => $item->stok - $request->jumlah[$i],
                    ]);

            }
        }


        return redirect(route("penjualan.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $datas = Penjualan::find($id);

        $data = [
            'datas' => $datas,
        ];
        return response()->view('penjualan.show', $data);
    }

    public function nota(string $id): Response
    {
        $datas = Penjualan::find($id);
        $profil = Profil::first();

        $data = [
            'datas' => $datas,
            'profil' => $profil,
        ];
        return response()->view('penjualan.nota', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $datas = Penjualan::find($id);
        $pelanggans = Pelanggan::all();

        $data = [
            'datas' => $datas,
            'pelanggans' => $pelanggans
        ];

        return response()->view('penjualan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $penjualan = Penjualan::find($id);
        $old_detail = DetailPenjualan::where("penjualan_id", $penjualan->id);

        $penjualan->update([
            "pelanggan_id" => $request->pelanggan_id,
            "tanggal_penjualan" => $request->tanggal,
            "nomor_nota" => $request->no_penjualan,
            "pengguna_id" => auth()->user()->id
        ]);

        // dd($old_detail->count());

        foreach($old_detail->get() as $o){
            $item_old = Item::find($o->item_id);
            $item_old->update([
                "stok" => $item_old->stok + $o->qty
            ]);
        }

        $old_detail->delete();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailPenjualan::create([
                        "penjualan_id" => $penjualan->id,
                        "item_id" => $request->id[$i],
                        "qty" => $request->jumlah[$i],
                        "diskon" => $request->diskon[$i],
                        "harga_item" => $item->harga_item,
                    ]);

                    $item->update([
                        "stok" => $item->stok - $request->jumlah[$i],
                    ]);
            }
        }

        return redirect(route("penjualan.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = Penjualan::find($id);
            $detail = DetailPenjualan::where("penjualan_id", $data->id);
            $detail->delete();
            $data->delete();
            DB::commit();
            return redirect()->route('penjualan.index')->with('success','Penjualan berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('penjualan.index')->with('error','Penjualan gagal dihapus');
        }
    }

    public function retur_penjualan(String $id)
    {
        DB::beginTransaction();
        try{
            $detail_penjualan = DetailPenjualan::find($id);
            $penjualan = $detail_penjualan->penjualan_id;

            $item = Item::find($detail_penjualan->item_id);

            $item->update([
                'stok' =>  $item->stok + $detail_penjualan->qty,
            ]);

            $detail_penjualan->delete();

            DB::commit();
            return redirect()->route('penjualan.show', $penjualan)->with('success','Barang Berhasil diretur');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('penjualan.show', $penjualan)->with('error','Barang gagal diretur');
        }
    }

    public function list_detail(Request $request)
    {
        $penjualan = Penjualan::find($request->id_penjualan);


        return response()->json([
            'data'=>$penjualan->detail_penjualan->get()
        ]);
    }
}
