<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiPengembalianController extends Controller
{
    public function store(Request $request):JsonResponse
    {
        // if($request->json()){
        //     $validator = Validator::make($request->all(), [
        //         "detail_penjualan.*"  => "required|array",
                
        //     ]);
        // } else {
        //     $validator = Validator::make($request->all(), [
        //         "item_id.*"  => "required|integer",
        //         "qty.*"  => "required|integer",
        //     ]);
        // }

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message'=>'invalid',
        //         'data'=>$validator->getMessageBag()
        //     ],422);
        // }

        // Log::info($request->all());

        DB::beginTransaction();
        try {
            $last_pengembalian = Pengembalian::where('pengguna_id',$request->user()->id)->latest()->first();
            $nomor_nota = 1;
            if($last_pengembalian){
                $nomor_nota = explode("-",$last_pengembalian->nomor_nota)[1]+1;
            }
            if($request->json()){
                $json = $request->json()->all();
                Log::info($json);
                $pengembalian = Pengembalian::create([
                    'pengguna_id'=>$request->user()->id,
                    'nomor_nota'=> date("Ymd-").$nomor_nota,
                    'tanggal_pengembalian'=>date("Y-m-d"),
                    'penjualan_id'=>$request->penjualan_id
                ]);
                foreach ($json['detail_pengembalian'] as $key => $value) {
                    $pengembalian->detail_pengembalians()->create([
                        'detail_penjualan_id'=>$value['detail_penjualan_id'],
                        'qty'=>$value['qty'],
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>''
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
}
