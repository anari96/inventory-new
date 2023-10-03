<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembayaranHutang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PembayaranHutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Pembelian::where('metode_bayar', "kredit")->paginate(10);

        $data = [
           "datas" => $datas,
        ];

        return response()->view('pembayaran_hutang.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {

        $datas = Pembelian::find($id);
        $pembayaran_hutangs = PembayaranHutang::where("pembelian_id", $id)->get();

        $data = [
            "datas" => $datas,
            "pembayaran_hutangs" => $pembayaran_hutangs,
        ];

        return response()->view("pembayaran_hutang.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try{
            PembayaranHutang::create([
                "uang_bayar" => $request->uang_bayar,
                "pembelian_id" => $id,
            ]);

            DB::commit();
            return redirect()->route('pembayaran_hutang.index')->with('success','Pembayaran Hutang berhasil ditambah');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('pembayaran_hutang.index')->with('error','Pembayaran Hutang gagal ditambah');
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
