<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $transaksiPerMonthAndCategory = Transaction::totalPerMonthAndCategory()->get();
        $datasets = $transaksiPerMonthAndCategory->groupBy('nama_kategori')->map(function ($items, $key) {
            return [
                'label' => $key,
                'data' => $items->map(function ($item) {
                    return $item->total;
                }),
                'backgroundColor' => '#' . substr(md5(rand()), 0, 6) // Warna acak untuk setiap dataset
            ];
        });
        // buat bulan
        $months = $transaksiPerMonthAndCategory->groupBy('month')->map(function ($items, $key) {
            return date('F', mktime(0, 0, 0, $key, 10)); // Mengubah angka bulan menjadi nama bulan
        });

        $count = collect();
        $transactions = Transaction::all();
        $count["Penjualan"] = $transactions->sum('total_harga');
        $count["Transaksi"] = $transactions->count();
        $count["Penjualan bulan terakhir"] = Transaction::monthLatest()->sum('total_harga');
        $count["Transaksi Bulan terakhir"] = Transaction::monthLatest()->count();
        return view('home', compact('count', 'datasets', 'months'));
    }
}
