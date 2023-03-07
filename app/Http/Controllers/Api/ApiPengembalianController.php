<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiPengembalianController extends Controller
{
    public function store(Request $request):JsonResponse
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
