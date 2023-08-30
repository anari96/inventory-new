<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Pelanggan::paginate(10);
        return response()->view("pelanggan.index", compact("datas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view("pelanggan.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Pelanggan::create([
            "nama_pelanggan" => $request->nama_pelanggan,
            "telp_pelanggan" => $request->telp_pelanggan,
            "alamat_pelanggan" => $request->alamat_pelanggan,
        ]);

        return redirect(route("pelanggan.index"));
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
        $data = Pelanggan::find($id);
        return response()->view("pelanggan.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = Pelanggan::find($id);
        DB::beginTransaction();
        try {
            $data->update([
                "nama_pelanggan" => $request->nama_pelanggan,
                "telp_pelanggan" => $request->telp_pelanggan,
                "alamat_pelanggan" => $request->alamat_pelanggan,
            ]);

            DB::commit();
            return redirect()->route("pelanggan.index")->with('success','data berhasil disimpan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('pelanggan.index')->with('error', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = Pelanggan::find($id);

            $penjualan = Penjualan::where('pelanggan_id', $data->id);
            $service = Service::where('pelanggan_id', $data->id);

            $penjualan->delete();
            $service->delete();
            $data->delete();

            DB::commit();
            return redirect()->route('pelanggan.index')->with('success','Pelanggan berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('pelanggan.index')->with('error',$th);
        }
    }

    public function getPelanggan(string $id)
    {
        $datas = Pelanggan::find($id);

        return response()->json([
            'data' => $datas,
        ]);
    }
}
