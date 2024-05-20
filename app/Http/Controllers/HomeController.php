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


        $data = Transaction::totalPerMonth()->get();
        $transaksiPerMonth = $data->map(function ($item) {
            return [
                'year' => $item->year,
                'month' => $item->month,
                'total' => $item->total
            ];
        });

        $count = collect();
        $transactions = Transaction::all();
        $count["Total Transaksi"] = $transactions->count();
        $count["Total Penjualan 1 Bulan terakhir"] = Transaction::monthLatest()->sum('total_harga');
        $count["Total Penjualan"] = $transactions->sum('total_harga');
        $count["Total Transaksi 1 Bulan terakhir"] = Transaction::monthLatest()->count();
        return view('home', compact('count', 'datasets'));
    }
}
