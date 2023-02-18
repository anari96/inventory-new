<?php

use App\Http\Controllers\Api\ApiKategoriItemController;
use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiRegisterController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/profil-pengguna', function (Request $request) {
    return response()->json([
        'message'=>'success',
        'data'=>$request->user()
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
    //Route::resource('', ApiKategoriItemController::class);
});