<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
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
});
Route::get('/about', [HomeController::class, 'about'])->name('about');
