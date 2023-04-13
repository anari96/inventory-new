<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiDiskonController extends Controller
{
    public function index(Request $request)
    {
        $datas = Diskon::where('pengguna_id',auth()->user()->id);
        if(request()->has('search') && request()->search != ""){
            $datas = $datas->where('nama_diskon','like','%'.request()->search.'%');
        }
        return response()->json([
            'data'=>$datas->get()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_diskon' => 'required|string|min:1',
            'jenis_diskon' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message'=>'invalid',
                'data'=>$validator->getMessageBag()
            ],422);
        }

        DB::beginTransaction();
        try {
            $Diskon = Diskon::create([
                'pengguna_id' => $request->user()->id,
                'nama_diskon' => $request->nama_diskon,
                'jenis_diskon' => $request->jenis_diskon,
                'nilai_diskon' => $request->nilai_diskon,
            ]);

            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$Diskon
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message'=>$th->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Diskon $Diskon): JsonResponse
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diskon $Diskon): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diskon $Diskon): JsonResponse
    {   
        if($Diskon->pengguna_id != $request->user()->id) return response()->json([
            'message'=>'unauthorized'
        ],401);

        $validator = Validator::make($request->all(), [
            'nama_diskon' => 'required|string|min:1',
            'jenis_diskon' => 'required',
        ]);
        
        
        if ($validator->fails()) {
            return response()->json([
                'message'=>'invalid',
                'data'=>$validator->getMessageBag()
            ],422);
        }

        DB::beginTransaction();
        try {
            $Diskon->update([
                'nama_diskon' => $request->nama_diskon,
                'jenis_diskon' => $request->jenis_diskon,
                'nilai_diskon' => $request->nilai_diskon,
            ]);

            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$Diskon
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message'=>$th->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {   
        $Diskon = Diskon::find($id);
        if($Diskon->pengguna_id != auth()->user()->id) return response()->json([
            'message'=>'unauthorized'
        ],401);
        if (!$Diskon) {
            return response()->json([
                'message'=>'not found'
            ],404);
        }
        DB::beginTransaction();
        try {
            $Diskon->delete();
            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$Diskon
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message'=>$th->getMessage()
            ],500);
        }
    }
}
