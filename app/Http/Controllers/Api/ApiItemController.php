<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {   
        $datas = Item::where('pengguna_id',auth()->user()->id);
        if(request()->has('kategori_item_id') && request()->kategori_item_id != 0 && request()->kategori_item_id != null && request()->kategori_item_id != ''){
            $datas = $datas->where('kategori_item_id',request()->kategori_item_id);
        }

        if(request()->has('search') && request()->search != 0 && request()->search != null && request()->search != ''){
            $datas = $datas->where('nama_item','like','%'.request()->search.'%');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_item' => 'required|string|min:1|max:100',
            'kategori_item_id' => 'nullable|integer',
            'harga_item' => 'nullable|integer',
            'stok_item' => 'nullable|integer',
            'sku' => 'nullable|string',
            'barcode' => 'nullable|string',
            'warna_item' => [
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
            $gambar = null;
            if ($request->hasFile('gambar_item_file')) {
                //save image to storage
                $gambar = $request->file('gambar_item_file')->store('gambar_item');
            }
            $sku = $request->sku;
            if($sku == null){
                $sku = 10000+Item::where('pengguna_id',$request->user()->id)->count()+1;
            }
            $item = Item::create([
                'pengguna_id' => $request->user()->id,
                'kategori_item_id' => $request->kategori_item_id != 0 ? $request->kategori_item_id : null,
                'nama_item' => $request->nama_item,
                'harga_item' => $request->harga_item,
                'biaya_item'=>$request->biaya_item,
                'sku' => $sku,
                'barcode' => $request->barcode,
                'lacak_stok' => (($request->lacak_stok || $request->lacak_stok == 'true') && $request->lacak_stok != 'false') ? true : false,
                'stok' => $request->stok ?? 0,
                'tipe_jual' => $request->tipe_jual,
                'warna_item' => $request->warna_item,
                'bentuk_item'=>$request->bentuk_item,
                'gambar_item' => $gambar,
            ]);
            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$item
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
    public function show(Item $item): JsonResponse
    {   
        $data = Item::where('id',$item->id)->with('kategoriItem')->first();
        return response()->json([
            'message'=>'success',
            'data'=>$data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item): JsonResponse
    {   
        if($item->pengguna_id != $request->user()->id) return response()->json([
            'message'=>'unauthorized'
        ],401);

        $validator = Validator::make($request->all(), [
            'nama_item' => 'required|string|min:1|max:100',
            'kategori_item_id' => 'nullable|integer',
            'harga_item' => 'required|integer',
            'stok_item' => 'nullable|integer',
            'sku' => 'nullable|string',
            'barcode' => 'nullable|string',
            'warna_item' => [
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
        $old_gambar = $item->gambar_item;
        $gambar = null;
        DB::beginTransaction();
        try {
            
            if ($request->hasFile('gambar_item')) {
                //save image to storage
                $gambar = $request->file('gambar_item')->store('gambar_item');
            }
            
            $item->update([
                'kategori_item_id' => $request->kategori_item_id != 0 ? $request->kategori_item_id : null,
                'nama_item' => $request->nama_item,
                'harga_item' => $request->harga_item,
                'biaya_item'=>$request->biaya_item,
                'sku' => $request->sku,
                'barcode' => $request->barcode,
                'lacak_stok' => (($request->lacak_stok || $request->lacak_stok == 'true') && $request->lacak_stok != 'false') ? true : false,
                'stok' => $request->stok ?? 0,
                'tipe_jual' => $request->tipe_jual,
                'warna_item' => $request->warna_item,
                'bentuk_item'=>$request->bentuk_item,
                'gambar_item' => $gambar,
            ]);
            if($old_gambar != null && Storage::exists($old_gambar) && $gambar != null) Storage::delete($old_gambar);
            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$item
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
        $item = Item::find($id);
        if($item->pengguna_id != auth()->user()->id) return response()->json([
            'message'=>'unauthorized'
        ],401);
        if (!$item) {
            return response()->json([
                'message'=>'not found'
            ],404);
        }
        DB::beginTransaction();
        try {
            $item->delete();
            if($item->gambar_item != null && Storage::exists($item->gambar_item)) Storage::delete($item->gambar_item);
            DB::commit();
            return response()->json([
                'message'=>'success',
                'data'=>$item
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message'=>$th->getMessage()
            ],500);
        }
    }

    public function generateSku()
    {   
        $skus = Item::where('pengguna_id',auth()->user()->id)->orderBy('sku','asc')->pluck('sku')->toArray();
        $int_skus = [];
        for ($i=0; $i < count($skus); $i++) { 
            if(is_numeric($skus[$i]) && (int)$skus[$i] >= 1000) $int_skus[] = $skus[$i];
        } 
        if(count($int_skus) > 0){
            $new_arr = range($skus[0],max($int_skus));                                                    
            // use array_diff to find the missing elements 
            $missing = array_diff($new_arr, $int_skus);
            if(count($missing) > 0){
                $sku = min($missing);
            } else{
                $sku = max($int_skus)+1;
            }
        } else {
            $sku = 10000+Item::where('pengguna_id',auth()->user()->id)->count()+1;
        }
        return response()->json([
            'message'=>'success',
            'data'=>$sku
        ]);
    }

    public function getGambarItem($id)
    {
        $item = Item::find($id);
        if($item->pengguna_id != auth()->user()->id) return response()->json([
            'message'=>'unauthorized'
        ],401);
        if (!$item) {
            return response()->json([
                'message'=>'not found'
            ],404);
        }
        if($item->gambar_item != null && Storage::exists($item->gambar_item)){
            return response()->download(storage_path('app/'.$item->gambar_item));
        } else {
            return response()->json([
                'message'=>'not found'
            ],404);
        }
    }
}
