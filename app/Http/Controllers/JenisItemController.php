<?php

namespace App\Http\Controllers;

use App\Models\JenisItem;
use App\Models\KategoriItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class JenisItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = JenisItem::paginate(10);

        $data=[
            "datas" => $datas,
        ];

        return response()->view('jenis_item.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {

        $kategori_item = KategoriItem::all();

        $data = [
            "kategori_item" => $kategori_item
        ];

        return response()->view("jenis_item.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $request->validate([
                "nama_jenis" => "required",
                "kategori_item_id" => "required",
            ]);
            JenisItem::create([
                "nama_jenis" => $request->nama_jenis,
                "kategori_item_id" => $request->kategori_item_id,
            ]);

            DB::commit();
            return redirect()->route('jenis_item.index')->with('success','Jenis Item berhasil ditambah');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('jenis_item.create')->with('error', $th->getMessage() );
        }
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
        $datas = JenisItem::find($id);
        $kategori_item = KategoriItem::all();

        $data = [
            "datas" => $datas,
            "kategori_item" => $kategori_item
        ];

        return response()->view("jenis_item.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try{

            $request->validate([
                "nama_jenis" => "required",
                "kategori_item_id" => "required",
            ]);

            $jenis_item = JenisItem::find($id);

            $jenis_item->update([
                "nama_jenis" => $request->nama_jenis,
                "kategori_item_id" => $request->kategori_item_id,
            ]);


            DB::commit();
            return redirect()->route("jenis_item.index")->with('success','data berhasil disimpan');
        } catch(\Throwable $th){

            DB::rollback();
            return redirect()->route('jenis_item.edit')->with('error', $th->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = JenisItem::find($id);

            $data->delete();

            DB::commit();
            return redirect()->route('jenis_item.index')->with('success','Jenis Item berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('jenis_item.index')->with('error',$th->getMessage());
        }
    }
}
