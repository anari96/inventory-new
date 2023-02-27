<?php

use App\Http\Controllers\Api\ApiItemController;
use App\Http\Controllers\Api\ApiKategoriItemController;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiPenjualanController;
use App\Http\Controllers\Api\ApiRegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('test-json',function(Request $request){
    
    if($request->json()){
        $json = $request->json()->all();
        foreach ($json['detail_penjualan'] as $key => $value) {
            dd($value);
        }
        dd($request->detail_penjualan);
    } else {
        dd('not ajax');
    }
    //dd($request->detail_penjualan[0]['id']);
});

Route::middleware('auth:sanctum')->get('/profil-pengguna', function (Request $request) {
    return response()->json([
        'message'=>'success',
        'data'=>Auth::user()
    ]);
});

Route::post('register', [ApiRegisterController::class,'register'])->name('register');
Route::post('login', [ApiLoginController::class,'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'kategori-item'], function () {
        Route::get('/', [ApiKategoriItemController::class,'index']);
        Route::post('/store', [ApiKategoriItemController::class,'store']);
        Route::get('/{kategoriItem}', [ApiKategoriItemController::class,'show']);
        Route::post('/{kategoriItem}/update', [ApiKategoriItemController::class,'update']);
        Route::post('/{kategoriItem}/delete', [ApiKategoriItemController::class,'destroy']);
    });

    Route::group(['prefix' => 'item'], function () {
        Route::get('/generate-sku', [ApiItemController::class,'generateSku']);
        Route::get('/', [ApiItemController::class,'index']);
        Route::post('/store', [ApiItemController::class,'store']);
        Route::get('/{item}', [ApiItemController::class,'show']);
        Route::post('/{item}/update', [ApiItemController::class,'update']);
        Route::post('/{item}/delete', [ApiItemController::class,'destroy']);
        Route::get('/{item}/gambar-item', [ApiItemController::class,'getGambarItem']);
    });

    Route::group(['prefix' => 'penjualan'], function () {
        Route::get('/', [ApiPenjualanController::class,'index']);
        Route::post('/store', [ApiPenjualanController::class,'store']);
        Route::get('/{penjualan}', [ApiPenjualanController::class,'show']);
        // Route::post('/{item}/update', [ApiItemController::class,'update']);
        // Route::post('/{item}/delete', [ApiItemController::class,'destroy']);
    });
    //Route::resource('', ApiKategoriItemController::class);
});