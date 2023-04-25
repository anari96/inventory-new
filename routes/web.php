<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\KategoriItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
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
    Route::resource('kategori-item', KategoriItemController::class);
});

// Route::group(['middleware' => ['auth:penggunas']], function () {
//     Route::get('/', [DashboardController::class,'index'])->name('dashboard');
// });
