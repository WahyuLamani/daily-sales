<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    function scopeMonthLatest($query)
    {
        return $query->where('tanggal_transaksi', '>=', Carbon::now()->subMonth());
    }

    public function scopeTotalPerMonth($query)
    {
        return $query->select(
            DB::raw('YEAR(tanggal_transaksi) as year'),
            DB::raw('MONTH(tanggal_transaksi) as month'),
            DB::raw('SUM(total_harga) as total')
        )
            ->where('tanggal_transaksi', '>=', Carbon::now()->subYear())
            ->groupBy(DB::raw('YEAR(tanggal_transaksi)'), DB::raw('MONTH(tanggal_transaksi)'))
            ->orderBy(DB::raw('YEAR(tanggal_transaksi)'), 'asc')
            ->orderBy(DB::raw('MONTH(tanggal_transaksi)'), 'asc');
    }

    public function scopeTotalPerMonthAndCategory($query)
    {
        return $query->select(
            'product_categories.nama_kategori',
            DB::raw('YEAR(tanggal_transaksi) as year'),
            DB::raw('MONTH(tanggal_transaksi) as month'),
            DB::raw('SUM(total_harga) as total')
        )
            ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'products.id', '=', 'transaction_details.product_id')
            ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
            ->where('tanggal_transaksi', '>=', Carbon::now()->subYear())
            ->groupBy('product_categories.nama_kategori', 'year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc');
    }
}
