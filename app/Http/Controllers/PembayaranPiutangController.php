<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PembayaranPiutang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PembayaranPiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Penjualan::where('metode_bayar', "kredit")->paginate(10);

        $data = [
           "datas" => $datas,
        ];

        return response()->view('pembayaran_piutang.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('pembayaran_piutang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
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
        $datas = Penjualan::find($id);
        $pembayaran_piutangs = PembayaranPiutang::where("penjualan_id", $id)->get();

        $data = [
            "datas" => $datas,
            "pembayaran_piutangs" => $pembayaran_piutangs,
        ];

        return response()->view("pembayaran_piutang.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try{
            PembayaranPiutang::create([
                "uang_bayar" => $request->uang_bayar,
                "penjualan_id" => $id,
            ]);

            DB::commit();
            return redirect()->route('pembayaran_piutang.index')->with('success','Pembayaran Piutang berhasil ditambah');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('pembayaran_piutang.index')->with('error','Pembayaran Piutang gagal ditambah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }
}
