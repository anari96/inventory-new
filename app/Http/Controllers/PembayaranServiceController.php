<?php

namespace App\Http\Controllers;

use App\Models\PembayaranService;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PembayaranServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

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
        $pembayaran_services = PembayaranService::where('service_id', $datas->id)->get();

        $data = [
            "datas" => $datas,
            "pembayaran_services" => $pembayaran_services,
        ];

        return response()->view("pembayaran_service.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try{

            $datas = Service::find($id);

            if($request->uang_bayar >= $datas->grand_total){
                $datas->update([
                    "status_pembayaran" => "lunas"
                ]);
            }
            PembayaranService::create([
                "uang_bayar" => $request->uang_bayar,
                "service_id" => $id,
            ]);

            DB::commit();
            return redirect()->route('service.index')->with('success','Pembayaran Service berhasil ditambah');
        } catch (\Throwable $th){
            dd($th);
            // DB::rollback();
            return redirect()->route('service.index')->with('error','Pembayaran Service gagal ditambah');
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
