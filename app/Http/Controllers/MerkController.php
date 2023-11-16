<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\Merk;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Merk::paginate(10);
        return response()->view('merk.index', compact('datas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('merk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $kategori = Merk::create([
                'nama_merk'=>$request->nama_merk,
            ]);
            DB::commit();
            return redirect()->route('merk.index')->with('success','Data berhasil disimpan');
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('merk.index')->with('error','Data gagal disimpan');
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
        $datas = Merk::find($id);

        $data = [
            'datas' => $datas
        ];

        return response()->view('merk.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $merk = Merk::find($id);
        DB::beginTransaction();
        try {
            $merk->update([
                'nama_merk'=>$request->nama_merk,
            ]);
            DB::commit();
            return redirect()->route('merk.index')->with('success','Data berhasil disimpan');
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('merk.index')->with('error','Data gagal disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $merk = Merk::find($id);
        DB::beginTransaction();
        try {
            $merk->delete();
            DB::commit();
            return redirect()->route('merk.index')->with('success','Data berhasil dihapus');
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('merk.index')->with('error','Data gagal dihapus');
        }

    }
}
