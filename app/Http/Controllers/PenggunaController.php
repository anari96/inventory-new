<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Level;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $datas = Pengguna::paginate(10);

        $data=[
            "datas" => $datas,
        ];

        return response()->view('pengguna.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $level = Level::all();

        $data = [
            "level" => $level
        ];

        return response()->view("pengguna.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
        $request->validate([
            "nama_pengguna" => "required",
            "email" => "required",
            "level_id" => "required",
            "password" => "required",
            "c_password" => "required|same:password",
        ]);
            Pengguna::create([
                "nama_pengguna" => $request->nama_pengguna,
                "email" => $request->email,
                "level_id" => $request->level_id,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            return redirect()->route('pengguna.index')->with('success','Pengguna berhasil ditambah');
        } catch (\Throwable $th){
            DB::rollback();
            return redirect()->route('pengguna.create')->with('error', $th->getMessage() );
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
        $datas = Pengguna::find($id);
        $level = Level::all();

        $data = [
            "datas" => $datas,
            "level" => $level
        ];

        return response()->view("pengguna.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try{

            if(isset($request->password)){
                $request->validate([
                    "nama_pengguna" => "required",
                    "email" => "required",
                    "level_id" => "required",
                    "password" => "required",
                    "c_password" => "required|same:password",
                ]);
            }else{
                $request->validate([
                    "nama_pengguna" => "required",
                    "email" => "required",
                    "level_id" => "required",
                ]);
            }

            $pengguna = Pengguna::find($id);

            $pengguna->update([
                "nama_pengguna" => $request->nama_pengguna,
                "email" => $request->email,
                "level_id" => $request->level_id,
            ]);


            if(isset($request->password)){
                $pengguna->update([
                    "password" => Hash::make($request->password),
                ]);
            }

            DB::commit();
            return redirect()->route("pengguna.index")->with('success','data berhasil disimpan');
        } catch(\Throwable $th){

            DB::rollback();
            return redirect()->route('pengguna.edit')->with('error', $th->getMessage() );
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = Pengguna::find($id);

            $data->delete();

            DB::commit();
            return redirect()->route('pengguna.index')->with('success','Pengguna berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('pengguna.index')->with('error',$th->getMessage());
        }
    }
}
