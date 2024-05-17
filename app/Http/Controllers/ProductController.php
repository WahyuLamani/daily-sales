<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory as Category;
use App\Models\Product;
use Alert;

class ProductController extends Controller
{
    function index()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('product',compact('categories','products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk' => ['required'],
            'kategori' => ['required'],
            'harga' => ['required'],
            'stok' => ['required']
        ]);
        Product::create([
            'nama_produk' => $request->produk,
            'product_category_id' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);
        return redirect('products')->withSuccess('Berhasil dibuat');
    }
}
