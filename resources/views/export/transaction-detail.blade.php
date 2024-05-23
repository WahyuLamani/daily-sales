<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        .header, .footer {
            padding: 20px 0;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            padding: 0;
        }

        .transaction-details, .user-details {
            margin-bottom: 20px;
        }

        .transaction-details table, .user-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .transaction-details th, .transaction-details td, 
        .user-details th, .user-details td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .products-table th, .products-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .products-table th {
            background: #f4f4f4;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }

        .print-date {
            text-align: right;
            font-size: 12px;
            color: #777;
            padding-top: 1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Detail Transaksi</h2>
        </div>

        <div class="transaction-details">
            <table>
                <tr>
                    <th>Transaction ID</th>
                    <td>{{ $transaction->id }}</td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td>{{ $transaction->tanggal_transaksi->format('d M, Y') }}</td>
                </tr>
                <tr>
                    <th>Print Date</th>
                    <td>{{ $printDate }}</td>
                </tr>
            </table>
        </div>

        <div class="user-details">
            <table>
                <tr>
                    <th>User Information</th>
                    <td>
                        Name: {{ $transaction->user->name }}<br>
                        Email: {{ $transaction->user->email }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="products">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->transactionDetails as $detail)
                    <tr class="item">
                        <td>{{ $detail->product->nama_produk }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td style="text-align: right;">Rp.{{ number_format($detail->product->harga , 2) }}</td>
                        <td  style="text-align: right;">Rp.{{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total">
            Total: Rp.{{ number_format($transaction->total_harga , 2)  }}
        </div>

        <div class="">
            <p class="print-date">Printed on: {{ $printDate }}</p>
        </div>
    </div>
</body>
</html>
