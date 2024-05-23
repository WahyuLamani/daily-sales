<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::all();
        return view('category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required'],
        ]);

        ProductCategory::create([
            'nama_kategori' => $request->category
        ]);
        return redirect('category')->withSuccess('Berhasil dibuat');
    }

    public function update(Request $request, ProductCategory $category)
    {
        $category->nama_kategori = $request->categoryNew;
        $category->save();
        return response()->json(['status' => 'success', 'message' => 'Categori berhasil diperbarui.']);
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();
        return response()->json(['status' => 'success', 'message' => "Categori berhasil di hapus."]);
    }
}
