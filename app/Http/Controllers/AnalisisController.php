<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AnalisisController extends Controller
{
    public function index()
    {
        $kategoris = ProductCategory::all();
        return view('analisis', compact('kategoris'));
    }
    public function getTransaksiData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kategoriId = $request->input('kategori');

        $transaksiData = Transaction::getTransaksiByCategoryAndDateRange($startDate, $endDate, $kategoriId)->get();
        return response()->json($transaksiData);
    }
}
