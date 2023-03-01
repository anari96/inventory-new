<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {   
        $datas = Penjualan::where('pengguna_id',auth()->user()->id)->get();
        $datas = $datas->map(function($data){
            $data->total = $data->detail_penjualan->sum('total');
            return $data;
        });
        return response()->json([
            'data'=>$datas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        if($request->json()){
            $validator = Validator::make($request->all(), [
                "detail_penjualan.*"  => "required|array",
                
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                "item_id.*"  => "required|integer",
                "qty.*"  => "required|integer",
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'message'=>'invalid',
                'data'=>$validator->getMessageBag()
            ],422);
        }

        DB::beginTransaction();
        try {
            $last_penjualan = Penjualan::where('pengguna_id',$request->user()->id)->latest()->first();
            $nomor_nota = 1;
            if($last_penjualan){
                $nomor_nota = explode("-",$last_penjualan->nomor_nota)[1]+1;
            }
            $penjualan = Penjualan::create([
                'pengguna_id' => $request->user()->id,
                'tanggal_penjualan' => date("Y-m-d"),
                'nomor_nota' => date("Ymd-").$nomor_nota,
            ]);

            if($request->json()){
                $json = $request->json()->all();
                foreach ($json['detail_penjualan'] as $key => $detail) {
                    $item = Item::find($detail['item_id']);
                    if($item->lacak_stok){
                        $item->stok = $item->stok - $detail['qty'];
                        $item->save();
                    }
                    $penjualan->detail_penjualan()->create([
                        'item_id' => $item->id,
                        'qty' => $detail['qty'],
                        'harga_item'=> $detail['harga_item'],
                        'nama_item'=> $item->nama_item,
                    ]);
                }
                Pembayaran::create([
                    'pengguna_id' => $request->user()->id,
                    'penjualan_id' => $penjualan->id,
                    'jumlah_bayar' => $json['pembayaran']['jumlah_bayar'],
                    'jenis_bayar' => $json['pembayaran']['jenis_bayar'],
                    'tanggal_bayar' => date("Y-m-d"),
                ]);
            } else {
                foreach ($request->item_id as $key => $item_id) {
                    $item = Item::find($item_id);
                    $penjualan->detail_penjualan()->create([
                        'item_id' => $item_id,
                        'qty' => $request->qty[$key],
                        'harga_item'=> $item->harga_item,
                        'nama_item'=> $item->nama_item,
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$penjualan
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return response()->json([
                'message'=>'failed',
                'data'=>$th->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan): JsonResponse
    {
        if($penjualan->pengguna_id != auth()->user()->id) return response()->json([
            'message'=>'unauthorized'
        ],401);
        return response()->json([
            'data'=>$penjualan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan): JsonResponse
    {
        //
    }
}
