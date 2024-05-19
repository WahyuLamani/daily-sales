<!DOCTYPE html>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<head>
    <title>Detail Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .details, .products {
            margin-bottom: 20px;
        }
        .products table {
            width: 100%;
            border-collapse: collapse;
        }
        .products table, .products th, .products td {
            border: 1px solid #000;
        }
        .products th, .products td {
            padding: 8px;
            text-align: left;
        }
        .footer {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detail Transaksi</h1>
            <p>ID Transaksi: {{ $transaction->id }}</p>
            <small>Tanggal Cetak : {{Carbon\Carbon::now()}}</small>
        </div>
        <div class="details">
            <h3>Salesman</h3>
            <p>Nama: {{ $transaction->user->name }}</p>
            <p>Email: {{ $transaction->user->email }}</p>
        </div>
        <div class="products">
            <h3>Detail Produk</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->transactionDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->nama_produk }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ $detail->product->harga }}</td>
                        <td>{{ $detail->subtotal }}</td>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">
            <h3>Total Pembayaran: {{ $transaction->total_harga }}</h3>
        </div>
    </div>
</body>
</html>
