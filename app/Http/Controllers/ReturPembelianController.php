<?php

namespace App\Http\Controllers;

use App\Models\ReturPembelian;
use App\Models\DetailReturPembelian;
use App\Models\Item;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReturPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = ReturPembelian::paginate(10);
        $data = [
            'datas' => $datas
        ];

        return response()->view("retur_pembelian.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $data = [
        ];
        return response()->view("retur_pembelian.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $retur_pembelian = ReturPembelian::create([
            "tanggal" => $request->tanggal,
            "keterangan" => $request->keterangan,
            "no_pembelian" => $request->no_pembelian,
            "pengguna_id" => auth()->user()->id
        ]);

        $retur_pembelian->save();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailReturPembelian::create([
                        "retur_pembelian_id" => $retur_pembelian->id,
                        "item_id" => $request->id[$i],
                        "nama_item" => $item->nama_item,
                        "qty" => $request->jumlah[$i],
                    ]);

                    // $item->update([
                    //     "stok" => $item->stok - $request->jumlah[$i],
                    // ]);

            }
        }


        return redirect(route("retur_pembelian.index"));
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
        $datas = ReturPembelian::find($id);
        $data = [
            "datas" => $datas,
        ];
        return response()->view("retur_pembelian.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {

        $retur_pembelian = ReturPembelian::find($id);
        $old_detail = DetailReturPembelian::where("retur_pembelian_id", $retur_pembelian->id);

        $retur_pembelian->update([
            "tanggal_pembelian" => $request->tanggal,
            "keterangan" => $request->keterangan,
            "no_pembelian" => $request->no_pembelian,
            "pengguna_id" => auth()->user()->id
        ]);

        $old_detail->delete();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailReturPembelian::create([
                        "retur_pembelian" => $retur_pembelian->id,
                        "item_id" => $request->id[$i],
                        "nama_item" => $item->nama_item,
                        "qty" => $request->jumlah[$i],
                    ]);

                    // $item->update([
                    //     "stok" => $item->stok - $request->jumlah[$i],
                    // ]);

            }
        }

        return redirect(route("retur_pembelian.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = ReturPembelian::find($id);
            $detail = DetailReturPembelian::where("retur_pembelian_id", $data->id);
            $detail->delete();
            $data->delete();
            DB::commit();
            return redirect()->route('retur_pembelian.index')->with('success','Retur Pembelian berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('retur_pembelian.index')->with('error','Pembelian gagal dihapus');
        }
    }
}
