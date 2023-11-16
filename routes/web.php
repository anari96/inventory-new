<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KategoriItemController;
use App\Http\Controllers\JenisItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiGudangController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\ReturPembelianController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PembayaranPiutangController;
use App\Http\Controllers\PembayaranHutangController;
use App\Http\Controllers\PembayaranServiceController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\LaporanController;
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
Route::get('/servis_online', [ServiceController::class,'guest'])->name('service.guest');
Route::post('/guest/store', [ServiceController::class,'guest_store'])->name('service.guest.store');
Route::get('/guest/done', [ServiceController::class,'guest_done'])->name('service.guest_done');
Route::get('/login', [LoginController::class,'loginView'])->name('login');
Route::post('/login', [LoginController::class,'loginAuth'])->name('login.auth');
Route::group(['middleware' => ['auth:penggunas','auth']], function () {
    // Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class,'index'])->name('logout');
    Route::resource('item', ItemController::class);

    Route::get('profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::get('get-item', [ItemController::class,'getItem'])->name('get-item');
    Route::get('get-item-sparepart', [ItemController::class,'getItemSparepart'])->name('get-item-sparepart');
    Route::get('get-jenis-kategori',[JenisItemController::class,"getJenisByKategoriId"])->name('get-jenis-kategori');
    Route::resource('kategori-item', KategoriItemController::class);
    Route::resource('jenis_item', JenisItemController::class);
    Route::resource('diskon', DiskonController::class);

    Route::get('service/proses/{id}', [ServiceController::class, 'proses'])->name('service.proses');
    Route::get('/', [ServiceController::class, 'dashboard'])->name('service.dashboard');
    Route::get('service/list', [ServiceController::class, 'list'])->name('service.list');
    Route::get('service/list_terpakai', [ServiceController::class, 'list_terpakai'])->name('service.list_terpakai');
    Route::get('service/kas', [ServiceController::class, 'kas'])->name('service.kas');
    Route::get('service/garansi', [ServiceController::class, 'garansi'])->name('service.garansi');
    Route::resource('service', ServiceController::class);


    Route::get('penjualan/retur/{id}', [PenjualanController::class, 'retur_penjualan'])->name('penjualan.retur');
    Route::resource('penjualan', PenjualanController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::resource('merk', MerkController::class);
    Route::resource('teknisi', TeknisiController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('transaksi_gudang', TransaksiGudangController::class);
    Route::resource('level', LevelController::class);
    Route::resource('sale', SaleController::class);
    Route::resource('retur_penjualan', ReturPenjualanController::class);
    Route::resource('retur_pembelian', ReturPembelianController::class);
    Route::resource('role', RoleController::class);
    Route::resource('pembayaran_piutang', PembayaranPiutangController::class);
    Route::resource('pembayaran_hutang', PembayaranHutangController::class);
    Route::resource('pembayaran_service', PembayaranServiceController::class);
    Route::resource('pesan', PesanController::class);
    Route::get('laporan', [LaporanController::class,'index'])->name('laporan');
    Route::prefix('laporan')->group(function(){
        Route::get('/penjualan', [LaporanController::class,'penjualan'])->name('laporan.penjualan');
        Route::get('/pembelian', [LaporanController::class,'pembelian'])->name('laporan.pembelian');
        Route::get('/service', [LaporanController::class,'service'])->name('laporan.service');
    });
});

// Route::group(['middleware' => ['auth:penggunas']], function () {
//     Route::get('/', [DashboardController::class,'index'])->name('dashboard');
// });
