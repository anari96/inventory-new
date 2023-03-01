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
                $attachableType = DetailPenjualan::query();
                
            }
            if($object->jenis == 'pengembalian') {
                $relationName = 'detail_pengembalians';
                $relationKey = 'pengembalian_id';
                $attachableType = DetailPengembalian::query();
            }
            // $functionalAreas = $attachableType->whereHas($relationName, function($q) use ($object, $relationKey){
            //     $q->where($relationKey, $object->id);
            // })->get();

            //$object->detail =  $functionalAreas->toArray();
            //unset($object->detail_pengembalians);
            //$object->total = null;
            //$object->detail_pengembalians = null;
            $object->detail = $attachableType->where($relationKey, $object->id)->get();
            $object->setAttribute('total_struk', $object->detail->sum('total'));
            
        });

        return $datas;
    }
    public function index():JsonResponse
    {   
        $penjualans = Penjualan::selectRaw(DB::raw('id,created_at as tanggal,"penjualan" as jenis'))->where('pengguna_id',auth()->user()->id);
        $pengembalians = Pengembalian::selectRaw(DB::raw('id,created_at as tanggal,"pengembalian" as jenis'))->where('pengguna_id',auth()->user()->id)->unionAll($penjualans)->orderBy('tanggal','DESC')->get();
        $datas = $this->getRelatedData($pengembalians);
       
        return response()->json([
            'data'=>$datas
        ]);
    }
    
}
