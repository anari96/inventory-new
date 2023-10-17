<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Pesan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $datas = Service::find($id);
        $pesans = Pesan::where("service_id", $datas->id)->get();
        $isi_pesan = "Halo kak ". $datas->pelanggan->nama_pelanggan ." Salam Kenal 😊
Saya CS Divisi Servis HP dari Anggur Cell
Kami telah menerima pesan anda untuk konsultasi servis hp dengan rincian sebagai berikut:

Nama: ". $datas->pelanggan->nama_pelanggan ."
No. WA: ". $datas->pelanggan->telp_pelanggan ."
Alamat: ". $datas->pelanggan->alamat_pelanggan ."
Keterangan: ". $datas->deskripsi ."

apakah data tersebut benar?";

        $data = [
            "datas" => $datas,
            "pesans" => $pesans,
            "isi_pesan" => $isi_pesan,
        ];

        return response()->view("pesan.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $service = Service::find($id);

        DB::beginTransaction();
        try{
            $pesan = Pesan::create([
                "isi_pesan" => $request->isi_pesan,
                "service_id" => $id,
            ]);

            if($pesan){
                \Helper::sendWa($service->pelanggan->telp_pelanggan, $request->isi_pesan);
            }

            DB::commit();
            return redirect()->route('service.index')->with('success','Pesan berhasil Dikirim');
        } catch (\Throwable $th){
            dd($th);
            // DB::rollback();
            return redirect()->route('service.index')->with('error','Pesan gagal Dikirim');
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
