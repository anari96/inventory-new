<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KategoriItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [LoginController::class,'loginView'])->name('login');
Route::post('/login', [LoginController::class,'loginAuth'])->name('login.auth');
Route::group(['middleware' => ['auth:penggunas','auth']], function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class,'index'])->name('logout');
    Route::resource('item', ItemController::class);
    Route::get('get-item', [ItemController::class,'getItem'])->name('get-item');
    Route::resource('kategori-item', KategoriItemController::class);
    Route::resource('diskon', DiskonController::class);
    Route::post('service/proses/{id}', [ServiceController::class, 'proses'])->name('service.proses');
    Route::get('service/dashboard', [ServiceController::class, 'dashboard'])->name('service.dashboard');
    Route::get('service/list', [ServiceController::class, 'list'])->name('service.list');
    Route::get('service/list_terpakai', [ServiceController::class, 'list_terpakai'])->name('service.list_terpakai');
    Route::get('service/kas', [ServiceController::class, 'kas'])->name('service.kas');
    Route::get('service/garansi', [ServiceController::class, 'garansi'])->name('service.garansi');
    Route::resource('service', ServiceController::class);
    Route::get('get-sparepart', [SparepartController::class,'getSparepart'])->name('get-sparepart');
    Route::resource('sparepart', SparepartController::class);
    Route::resource('teknisi', TeknisiController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('supplier', SupplierController::class);
});

// Route::group(['middleware' => ['auth:penggunas']], function () {
//     Route::get('/', [DashboardController::class,'index'])->name('dashboard');
// });
