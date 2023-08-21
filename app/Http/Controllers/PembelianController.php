<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use DateInterval;
use DatePeriod;
use DateTime;

class PembelianController extends Controller
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


        $datas = Pembelian::whereBetween("created_at", [$begin->format('Y-m-d'), $end->format('Y-m-d')])->paginate(10);
        $data = [
            'datas' => $datas,
            "periode" => $periode,
            "periodeTanggals" => $periodeTanggals
        ];
        return response()->view('pembelian.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $suppliers = Supplier::all();
        $datas = [
            "suppliers" => $suppliers,
        ];
        return response()->view('pembelian.create', $datas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
       $pembelian = Pembelian::create([
            "supplier_id" => $request->supplier_id,
            "tanggal_pembelian" => $request->tanggal,
            "nomor_nota" => $request->no_pembelian,
            "pengguna_id" => auth()->user()->id
        ]);

       $pembelian->save();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailPembelian::create([
                        "pembelian_id" => $pembelian->id,
                        "item_id" => $request->id[$i],
                        "qty" => $request->jumlah[$i],
                        "diskon" => 0,
                        "harga_item" => $item->harga_item,
                    ]);

                    $item->update([
                        "stok" => $item->stok + $request->jumlah[$i],
                    ]);
            }
        }


        return redirect(route("pembelian.index"));
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
        $datas = Pembelian::find($id);
        $suppliers = Supplier::all();

        $data = [
            'datas' => $datas,
            'suppliers' => $suppliers
        ];

        return response()->view('pembelian.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $pembelian = Pembelian::find($id);
        $old_detail = DetailPembelian::where("pembelian_id", $pembelian->id);

        $pembelian->update([
            "supplier_id" => $request->supplier_id,
            "tanggal_pembelian" => $request->tanggal,
            "nomor_nota" => $request->no_pembelian,
            "pengguna_id" => auth()->user()->id
        ]);


        foreach($old_detail->get() as $o){
            $item_old = Item::find($o->item_id);
            $item_old->update([
                "stok" => $item_old->stok - $o->qty
            ]);
        }

        $old_detail->delete();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailPembelian::create([
                        "pembelian_id" => $pembelian->id,
                        "item_id" => $request->id[$i],
                        "qty" => $request->jumlah[$i],
                        "diskon" => 0,
                        "harga_item" => $item->harga_item,
                    ]);

                    $item->update([
                        "stok" => $item->stok + $request->jumlah[$i],
                    ]);
            }
        }

        return redirect(route("pembelian.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = Pembelian::find($id);
            $detail = DetailPembelian::where("pembelian_id", $data->id);
            $detail->delete();
            $data->delete();
            DB::commit();
            return redirect()->route('pembelian.index')->with('success','Pembelian berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('pembelian.index')->with('error','Pembelian gagal dihapus');
        }
    }
}
