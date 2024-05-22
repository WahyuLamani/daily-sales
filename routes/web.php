<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products', [ProductController::class, 'store'])->name('store.products');
    Route::get('/order', [TransactionController::class, 'index'])->name('transaction');
    Route::post('/order', [TransactionController::class, 'store'])->name('store.transaction');
    Route::get('produk/{id}/harga-stok', [TransactionController::class, 'getProductAmount']);
    Route::get('transaksi/{id}/pdf', [TransactionController::class, 'showPDF']);
    Route::get('transaksi/{id}/download', [TransactionController::class, 'downloadPDF']);

    Route::get('analisis', [AnalisisController::class, 'index'])->name('analisis');
    Route::get('transaksi-data', [AnalisisController::class, 'getTransaksiData'])->name('transaksi.data');
    Route::get('account/', [UserController::class, 'account'])->name('user.account');
    Route::post('account/', [UserController::class, 'update'])->name('user.account.update');
    Route::get('users/setting', [UserController::class, 'index'])->name('user.setting');
    Route::post('users/setting', [UserController::class, 'store'])->name('user.create');
    Route::delete('/users/setting/{user}', [UserController::class, 'destroy']);
    Route::post('/users/setting/{user}/reset-password', [UserController::class, 'resetPassword']);
});
Route::get('/about', [HomeController::class, 'about'])->name('about');
