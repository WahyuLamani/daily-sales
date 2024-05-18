<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('transactionDetail.nama_produk')->get();
        $products = Product::all();
        return view('transaction', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'produk.*.id_produk' => 'required|exists:produk,id_produk',
            'produk.*.jumlah' => 'required|integer|min:1',
            'produk.*.subtotal' => 'required|numeric|min:0',
        ]);

        $transaksi = Transaction::create([
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal_Transaction' => $request->tanggal_transaksi,
            'total_harga' => $request->total_harga,
            'status_pembayaran' => $request->status_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        foreach ($request->produk as $item) {
            TransactionDetail::create([
                'id_transaksi' => $transaksi->id,
                'id_produk' => $item['id_produk'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        return redirect()->route('transaction')->with('success', 'Transaksi berhasil dibuat');
    }
}
