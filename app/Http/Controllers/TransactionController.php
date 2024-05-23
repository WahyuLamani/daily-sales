<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin) {
            $transactions = Transaction::with('transactionDetails', 'user')->get();
        } else {
            $transactions = Transaction::where('user_id', '=', Auth::user()->id)
                ->with('transactionDetails', 'user')->get();
        }

        $products = Product::all();
        return view('transaction', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status_pembayaran' => 'required',
            'produk.*.id_produk' => 'required|exists:products,id',
            'produk.*.jumlah' => 'required|integer|min:1',
            'produk.*.subtotal' => 'required|numeric|min:0',
            'jumlah_pembayaran' => 'required|numeric|min:0',
        ]);
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

        $transaksi = Auth::user()->transactions()->create([
            'tanggal_transaksi' => isset($request->tanggal_transaksi) ? $request->tanggal_transaksi . ' ' . Carbon::now()->format('H:i:s') : Carbon::now()->format('Y-m-d H:i:s'),
            'total_harga' => $request->jumlah_pembayaran,
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        foreach ($request->produk as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaksi->id,
                'product_id' => $item['id_produk'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        return redirect()->route('transaction')->with('success', 'Transaksi berhasil');
    }
    public function getProductAmount($id)
    {
        $produk = Product::find($id);
        return response()->json(['harga' => $produk->harga, 'stok' => $produk->stok]);
    }

    public function showPDF($id)
    {
        $transaction = Transaction::with('transactionDetails', 'user')->findOrFail($id);
        $printDate = Carbon::now()->format('d M, Y H:i:s');
        $pdf = PDF::loadView('export.transaction-detail', compact('transaction', 'printDate'))->setPaper('a4');
        return $pdf->stream('transaksi_' . $id . '.pdf');
    }

    public function downloadPDF($id)
    {
        $transaction = Transaction::with('transactionDetails', 'user')->findOrFail($id);
        $printDate = Carbon::now()->format('d M, Y H:i:s');
        $pdf = PDF::loadView('export.transaction-detail', compact('transaction', 'printDate'))->setPaper('a4');
        return $pdf->download('invoice.pdf');
    }

    public function pay(Request $request)
    {
        $transaction = Transaction::findOrFail($request->id);
        $transaction->status_pembayaran = 'lunas';
        $transaction->save();

        return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil!']);
    }
}
