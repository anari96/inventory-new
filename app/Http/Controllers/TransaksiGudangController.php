<?php

namespace App\Http\Controllers;

use App\Models\TransaksiGudang;
use App\Models\DetailTransaksiGudang;
use App\Models\Item;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransaksiGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = TransaksiGudang::paginate(10);

        $data = [
            'datas' => $datas,
        ];

        return response()->view('transaksi_gudang.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $data = [
        ];

        return response()->view('transaksi_gudang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $transaksi_gudang = TransaksiGudang::create([
            "tanggal" => $request->tanggal,
            "keterangan" => $request->keterangan,
            "pengguna_id" => auth()->user()->id
        ]);

        $transaksi_gudang->save();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    $item = Item::find($request->id[$i]);

                    DetailTransaksiGudang::create([
                        "transaksi_gudang_id" => $transaksi_gudang->id,
                        "item_id" => $request->id[$i],
                        "nama_item" => $item->nama_item,
                        "qty" => $request->jumlah[$i],
                    ]);

                    $item->update([
                        "stok" => $item->stok + $request->jumlah[$i],
                    ]);

            }
        }


        return redirect(route("transaksi_gudang.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiGudang $transaksiGudang): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiGudang $transaksiGudang): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiGudang $transaksiGudang): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = TransaksiGudang::find($id);
            $detail = DetailTransaksiGudang::where("transaksi_gudang_id", $data->id);
            $detail->delete();
            $data->delete();
            DB::commit();
            return redirect()->route('transaksi_gudang.index')->with('success','Transaksi Gudang berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('transaksi_gudang.index')->with('error','Transaksi Gudang gagal dihapus');
        }
    }
}
