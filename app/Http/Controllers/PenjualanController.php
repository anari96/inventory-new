<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Penjualan::all();
        $data = [
            'datas' => $datas,
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
                    DetailPenjualan::create([
                        "penjualan_id" => $penjualan->id,
                        "item_id" => $request->id[$i],
                        "qty" => $request->jumlah[$i],
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
        return response()->view('penjualan.create', $datas);
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

        $old_detail->delete();

        if(isset($request->jumlah)){
            for($i = 0; $i < count($request->jumlah);$i++){
                    DetailPenjualan::create([
                        "penjualan_id" => $penjualan->id,
                        "item_id" => $request->id[$i],
                        "qty" => $request->jumlah[$i],
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
}
