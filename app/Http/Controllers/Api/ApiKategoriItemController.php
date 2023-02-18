<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiKategoriItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data'=>KategoriItem::where('pengguna_id',auth()->user()->id)->get()
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
            'nama_kategori' => 'required|string|min:1',
            'warna_kategori' => [
                'nullable',
                'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i' //rgb, rgba, hsl and hsla
            ],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message'=>'invalid',
                'data'=>$validator->getMessageBag()
            ],422);
        }

        DB::beginTransaction();
        try {
            $kategoriItem = KategoriItem::create([
                'pengguna_id' => $request->user()->id,
                'nama_kategori' => $request->nama_kategori,
                'warna_kategori' => $request->warna_kategori,
            ]);

            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$kategoriItem
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
    public function show(KategoriItem $kategoriItem): JsonResponse
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriItem $kategoriItem): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriItem $kategoriItem): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|min:1',
            'warna_kategori' => [
                'nullable',
                'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i' //rgb, rgba, hsl and hsla
            ],
        ]);
        if($kategoriItem->pengguna_id != $request->user()->id) return response()->json([
            'message'=>'unauthorized'
        ],401);
        
        if ($validator->fails()) {
            return response()->json([
                'message'=>'invalid',
                'data'=>$validator->getMessageBag()
            ],422);
        }

        DB::beginTransaction();
        try {
            $kategoriItem->update([
                'nama_kategori' => $request->nama_kategori,
                'warna_kategori' => $request->warna_kategori,
            ]);

            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$kategoriItem
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
        $kategoriItem = KategoriItem::find($id);
        if (!$kategoriItem) {
            return response()->json([
                'message'=>'not found'
            ],404);
        }
        DB::beginTransaction();
        try {
            $kategoriItem->delete();
            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$kategoriItem
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message'=>$th->getMessage()
            ],500);
        }
    }
}
