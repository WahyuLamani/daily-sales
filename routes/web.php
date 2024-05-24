<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\CategoryController;
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

Route::get('/lupapassword', function () {
    return view('lupa-password');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/order', [TransactionController::class, 'index'])->name('transaction');
    Route::post('/order', [TransactionController::class, 'store'])->name('store.transaction');
    Route::post('/order/payment', [TransactionController::class, 'pay'])->name('pay.transaction');
    Route::get('produk/{id}/harga-stok', [TransactionController::class, 'getProductAmount']);
    Route::get('transaksi/{id}/pdf', [TransactionController::class, 'showPDF']);
    Route::get('transaksi/{id}/download', [TransactionController::class, 'downloadPDF']);
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::post('/products', [ProductController::class, 'store'])->name('store.products');
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::get('/category', [CategoryController::class, 'index'])->name('category');
        Route::post('/category', [CategoryController::class, 'store'])->name('store.category');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('update.category');
        Route::delete('/category/{category}', [CategoryController::class, 'destroy']);
        Route::get('/users/setting', [UserController::class, 'index'])->name('user.setting');
        Route::post('/users/setting', [UserController::class, 'store'])->name('user.create');
        Route::delete('/users/setting/{user}', [UserController::class, 'destroy']);
        Route::post('/users/setting/{user}/reset-password', [UserController::class, 'resetPassword']);
        Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis');
        Route::get('/transaksi-data', [AnalisisController::class, 'getTransaksiData'])->name('transaksi.data');
    });
    Route::get('/account', [UserController::class, 'account'])->name('user.account');
    Route::post('/account', [UserController::class, 'update'])->name('user.account.update');
});
