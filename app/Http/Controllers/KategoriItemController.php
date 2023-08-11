<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KategoriItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = KategoriItem::paginate(10);
        return response()->view('kategori-item.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $colors = [
            "#F44336",
            "#2196F3",
            "#4CAF50",
            "#FFEB3B",
            "#9C27B0",
            "#FF9800",
            "#795548",
            "#9E9E9E",
        ];
        return response()->view('kategori-item.create',compact('colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $kategori = KategoriItem::create([
                'pengguna_id'=>Auth::user()->id,
                'nama_kategori'=>$request->nama_kategori,
            ]);
            DB::commit();
            return redirect()->route('kategori-item.index')->with('success','Data berhasil disimpan');
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kategori-item.index')->with('error','Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriItem $kategoriItem): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriItem $kategoriItem): Response
    {
        $colors = [
            "#F44336",
            "#2196F3",
            "#4CAF50",
            "#FFEB3B",
            "#9C27B0",
            "#FF9800",
            "#795548",
            "#9E9E9E",
        ];
        return response()->view('kategori-item.edit',[
            'colors'=>$colors,
            'data'=>$kategoriItem
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriItem $kategoriItem): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $kategoriItem->update([
                'nama_kategori'=>$request->nama_kategori,
                'warna_kategori'=>$request->warna_kategori,
            ]);
            DB::commit();
            return redirect()->route('kategori-item.index')->with('success','Data berhasil disimpan');
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kategori-item.index')->with('error','Data gagal disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriItem $kategoriItem): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $kategoriItem->delete();
            DB::commit();
            return redirect()->route('kategori-item.index')->with('success','Data berhasil dihapus');
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('kategori-item.index')->with('error','Data gagal dihapus');
        }
    }
}
