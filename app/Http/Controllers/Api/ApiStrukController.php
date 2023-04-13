<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailPengembalian;
use App\Models\DetailPenjualan;
use App\Models\Pengembalian;
use App\Models\Penjualan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiStrukController extends Controller
{   
    private function getRelatedData($datas)
    {
        $datas->map(function($object) {
            if($object->jenis == 'penjualan') {
                $relationName = 'detail_penjualan';
                $relationKey = 'penjualan_id';
                $attachableType = DetailPenjualan::with('detail_pengembalians')->with('diskons');
                
            }
            if($object->jenis == 'pengembalian') {
                $relationName = 'detail_pengembalians';
                $relationKey = 'pengembalian_id';
                $attachableType = DetailPengembalian::query();

                $object->penjualan = Penjualan::find($object->penjualan_id);
            }
            // $functionalAreas = $attachableType->whereHas($relationName, function($q) use ($object, $relationKey){
            //     $q->where($relationKey, $object->id);
            // })->get();

            //$object->detail =  $functionalAreas->toArray();
            //unset($object->detail_pengembalians);
            //$object->total = null;
            //$object->detail_pengembalians = null;
            $object->detail_struk = $attachableType->where($relationKey, $object->id)->get()->map(function ($detail)
            {
                if($detail->detail_penjualan_id != null) {
                    $detail->nama_item = $detail->detail_penjualan->nama_item;
                    $detail->harga_item = $detail->detail_penjualan->harga_item;
                    
                }
                
                return $detail;
                
            });
            $object->setAttribute('total_struk', $object->detail_struk->sum('total'));
            return $object;
        });

        return $datas;
    }
    public function index():JsonResponse
    {   
        $penjualans = Penjualan::selectRaw(DB::raw('id,nomor_nota,pengguna_id,created_at as tanggal,"penjualan" as jenis'))->where('pengguna_id',auth()->user()->id);
        $pengembalians = Pengembalian::selectRaw(DB::raw('id,nomor_nota,penjualan_id,created_at as tanggal,"pengembalian" as jenis'))->where('pengguna_id',auth()->user()->id)->unionAll($penjualans)->orderBy('tanggal','DESC')->get();
        $datas = $this->getRelatedData($pengembalians);
       
        return response()->json([
            'data'=>$datas
        ]);
    }
    
}
