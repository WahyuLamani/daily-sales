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
        $transactions = Transaction::with('transactionDetails.nama_produk')->get();
        $products = Product::all();
        return view('transaction', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'tanggal_transaksi' => 'required|date',
        //     'produk.*.id_produk' => 'required|exists:produk,id_produk',
        //     'produk.*.jumlah' => 'required|integer|min:1',
        //     'produk.*.subtotal' => 'required|numeric|min:0',
        // ]);
        foreach ($request->produk as $item) {
            $produk = Product::find($item['id_produk']);

            // Periksa apakah jumlah pembelian melebihi stok
            if ($produk->stok < $item['jumlah']) {
                return redirect()->back()->with('error', 'Jumlah pembelian melebihi stok produk ' . $produk->nama_produk);
            }

            // Kurangi stok produk
            $produk->update([
                'stok' => $produk->stok - $item['jumlah'],
            ]);
        }

        $transaksi = Transaction::create([
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'total_harga' => $request->total_harga,
            'status_pembayaran' => $request->status_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
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
    function getProductAmount($id)
    {
        $produk = Product::find($id);
        return response()->json(['harga' => $produk->harga, 'stok' => $produk->stok]);
    }
}
