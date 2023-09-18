<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function index()
    {
        $datas = Profil::first();

        $data = [
            'datas' => $datas
        ];

        return response()->view('profil.index', $data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                "nama_toko" => "required",
                "alamat" => "required",
                "kontak" => "required",
                "keterangan" => "required",
            ]);

            $profil = Profil::first();

            $profil->update([
                "nama_toko" => $request->nama_toko,
                "alamat" => $request->alamat,
                "kontak" => $request->kontak,
                "keterangan" => $request->keterangan,
            ]);

            DB::commit();
            return redirect()->route('profil.index')->with('success','Profil berhasil diubah');
        } catch(\Throwable $th){
            DB::rollback();
            return redirect()->route('profil.index')->with('error', $th->getMessage() );
        }
    }
}
