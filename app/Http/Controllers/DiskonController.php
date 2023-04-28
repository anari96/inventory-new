<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Diskon::where('pengguna_id',auth()->user()->id)->paginate(10);
        return response()->view('diskon.index', compact('datas')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('diskon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_diskon' => 'required|string|min:1',
            'jenis_diskon' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('diskon.index')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $diskon = Diskon::create([
                'pengguna_id' => $request->user()->id,
                'nama_diskon' => $request->nama_diskon,
                'jenis_diskon' => $request->jenis_diskon,
                'nilai_diskon' => $request->nilai_diskon,
            ]);

            DB::commit();
            return redirect()->route('diskon.index')->with('success','Berhasil menambahkan diskon');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('diskon.index')->with('error','Gagal menambahkan diskon');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Diskon $diskon): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diskon $diskon): Response
    {
        return response()->view('diskon.edit',[
            'data'=>$diskon
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diskon $diskon): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_diskon' => 'required|string|min:1',
            'jenis_diskon' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('diskon.index')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $diskon->update([
                'nama_diskon' => $request->nama_diskon,
                'jenis_diskon' => $request->jenis_diskon,
                'nilai_diskon' => $request->nilai_diskon,
            ]);

            DB::commit();
            return redirect()->route('diskon.index')->with('success','Berhasil mengubah diskon');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('diskon.index')->with('error','Gagal mengubah diskon');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diskon $diskon): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $diskon->delete();
            DB::commit();
            return redirect()->route('diskon.index')->with('success','Berhasil menghapus diskon');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('diskon.index')->with('error','Gagal menghapus diskon');
        }
    }
}
