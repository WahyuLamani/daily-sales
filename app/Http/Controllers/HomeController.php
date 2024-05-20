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
        // Prepare labels for the last 12 months
        $labels = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels->push($date->format('F Y'));
        }

        $allCategories = $transaksiPerMonthAndCategory->pluck('nama_kategori')->unique();
        $datasets = [];

        // Initialize dataset for each category
        foreach ($allCategories as $category) {
            $datasets[$category] = array_fill(0, 12, 0);
        }

        // Fill the dataset with actual data
        foreach ($transaksiPerMonthAndCategory as $data) {
            $dateLabel = date('F Y', mktime(0, 0, 0, $data->month, 1, $data->year));
            $labelIndex = $labels->search($dateLabel);

            if ($labelIndex !== false) {
                $datasets[$data->nama_kategori][$labelIndex] = $data->total;
            }
        }

        // Format datasets for Chart.js
        $chartDatasets = collect($datasets)->map(function ($data, $label) {
            return [
                'label' => $label,
                'data' => $data,
                'backgroundColor' => '#' . substr(md5(rand()), 0, 6), // Warna acak untuk setiap dataset
                'borderColor' => '#' . substr(md5(rand()), 0, 6),
                'fill' => false
            ];
        })->values();

        $count = collect();
        $transactions = Transaction::all();
        $count["Penjualan"] = $transactions->sum('total_harga');
        $count["Transaksi"] = $transactions->count();
        $count["Penjualan bulan terakhir"] = Transaction::monthLatest()->sum('total_harga');
        $count["Transaksi Bulan terakhir"] = Transaction::monthLatest()->count();
        return view('home', [
            'labels' => $labels,
            'datasets' => $chartDatasets,
            'count' => $count
        ]);
    }
}
