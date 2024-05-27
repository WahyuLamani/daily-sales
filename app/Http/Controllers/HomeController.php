<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin) {
            $transaksiPerMonthAndCategory = Transaction::totalPerMonthAndCategory()
                ->get();
            $transactions = Transaction::all();
            $transactionMonth = Transaction::monthLatest();
        } else {
            $transaksiPerMonthAndCategory = Transaction::totalPerMonthAndCategory()
                ->where('user_id', '=', Auth::user()->id)
                ->get();
            $transactions = Transaction::where('user_id', '=', Auth::user()->id);
            $transactionMonth = Transaction::monthLatest()->where('user_id', '=', Auth::user()->id);
        }

        $dataSets = $this->populateDataToChart($transaksiPerMonthAndCategory);
        $count = collect();
        $count["Penjualan"] = $transactions->sum('total_harga');
        $count["Transaksi"] = $transactions->count();
        $count["Penjualan bulan terakhir"] = $transactionMonth->sum('total_harga');
        $count["Transaksi Bulan terakhir"] = $transactionMonth->count();
        return view('home', [
            'labels' => $dataSets['labels'],
            'datasets' => $dataSets['chartDatasets'],
            'count' => $count
        ]);
    }



    private function populateDataToChart($query)
    {
        // Prepare labels for the last 12 months
        $labels = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels->push($date->format('F Y'));
        }

        $allCategories = $query->pluck('nama_kategori')->unique();
        $datasets = [];

        // Initialize dataset for each category
        foreach ($allCategories as $category) {
            $datasets[$category] = array_fill(0, 12, 0);
        }

        // Fill the dataset with actual data
        foreach ($query as $data) {
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
        return ['chartDatasets' => $chartDatasets, 'labels' => $labels];
    }
}
