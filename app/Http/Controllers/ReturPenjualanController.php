<?php

namespace App\Http\Controllers;

use App\Models\ReturPenjualan;
use App\Models\DetailReturPenjualan;
use App\Models\Sale;
use App\Models\Item;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReturPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = ReturPenjualan::paginate(10);
        $data = [
            'datas' => $datas
        ];

        return response()->view("retur_penjualan.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        // $penjualan = Penjualan::all();
        $pelanggan = Pelanggan::all();
        $sales = Sale::all();
        $data = [
            // "penjualans" => $penjualan,
            "pelanggans" => $pelanggan,
            "sales" => $sales
        ];
        return response()->view("retur_penjualan.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $retur_penjualan = ReturPenjualan::create([
            "pelanggan_id" => $request->pelanggan_id,
            "sale_id" => $request->sale_id,
            "tanggal_penjualan" => $request->tanggal,
            "keterangan" => $request->keterangan,
            "no_penjualan" => $request->no_penjualan,
            "pengguna_id" => auth()->user()->id
        ]);

        $retur_penjualan->save();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailReturPenjualan::create([
                        "retur_penjualan_id" => $retur_penjualan->id,
                        "item_id" => $request->id[$i],
                        "nama_item" => $item->nama_item,
                        "qty" => $request->jumlah[$i],
                    ]);

                    // $item->update([
                    //     "stok" => $item->stok - $request->jumlah[$i],
                    // ]);

            }
        }


        return redirect(route("retur_penjualan.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $datas = ReturPenjualan::find($id);
        $pelanggan = Pelanggan::all();
        $sales = Sale::all();
        $data = [
            // "penjualans" => $penjualan,
            "datas" => $datas,
            "pelanggans" => $pelanggan,
            "sales" => $sales
        ];
        return response()->view("retur_penjualan.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $retur_penjualan = ReturPenjualan::find($id);
        $old_detail = DetailReturPenjualan::where("retur_penjualan_id", $retur_penjualan->id);

        $retur_penjualan->update([
            "pelanggan_id" => $request->pelanggan_id,
            "sale_id" => $request->sale_id,
            "tanggal_penjualan" => $request->tanggal,
            "keterangan" => $request->keterangan,
            "no_penjualan" => $request->no_penjualan,
            "pengguna_id" => auth()->user()->id
        ]);

        $old_detail->delete();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailReturPenjualan::create([
                        "retur_penjualan_id" => $retur_penjualan->id,
                        "item_id" => $request->id[$i],
                        "nama_item" => $item->nama_item,
                        "qty" => $request->jumlah[$i],
                    ]);

                    // $item->update([
                    //     "stok" => $item->stok - $request->jumlah[$i],
                    // ]);

            }
        }

        return redirect(route("retur_penjualan.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = ReturPenjualan::find($id);
            $detail = DetailReturPenjualan::where("retur_penjualan_id", $data->id);
            $detail->delete();
            $data->delete();
            DB::commit();
            return redirect()->route('retur_penjualan.index')->with('success','Retur Penjualan berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('retur_penjualan.index')->with('error','Penjualan gagal dihapus');
        }
    }
}
