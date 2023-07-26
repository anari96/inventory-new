<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Sparepart;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Sparepart::paginate(10);
        return response()->view("sparepart.index", compact("datas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view("sparepart.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Sparepart::create([
            "nama_sparepart" => $request->nama_sparepart,
            "tipe" => $request->tipe,
            "harga_beli" => $request->harga_beli,
            "harga_jual" => $request->harga_jual,
            "stok" => $request->stok,
        ]);

        return redirect(route("sparepart.index"));
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
        $data = Sparepart::find($id);

        return response()->view("sparepart.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = Sparepart::find($id);

        $data->update([
            "nama_sparepart" => $request->nama_sparepart,
            "tipe" => $request->tipe,
            "harga_beli" => $request->harga_beli,
            "harga_jual" => $request->harga_jual,
            "stok" => $request->stok,
        ]);

        return redirect(route("sparepart.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = Sparepart::find($id);
            $data->delete();
            DB::commit();
            return redirect()->route('sparepart.index')->with('success','Item berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('sparepart.index')->with('error','Item gagal dihapus');
        }
    }

    public function getSparepart(Request $request)
    {

        if(request()->has('search') && request()->search != 0 && request()->search != null && request()->search != ''){
            $datas = Sparepart::where('id','like','%'.request()->search.'%')->get();
        }else{
            $datas = Sparepart::all();
        }

        return response()->json([
            'data'=>$datas
        ]);
    }
}
