<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Detail Pesanan #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
             min-height: 100vh; /* Ensure gradient covers full height */
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #6a11cb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
         h2 {
            color: #555;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
         }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            color: #555;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
         .back-link {
             display: inline-block;
             margin-top: 20px;
             color: #6a11cb;
             text-decoration: none;
             transition: color 0.3s ease;
         }
         .back-link:hover {
             color: #2575fc;
             text-decoration: underline;
         }

    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Pesanan #{{ $order->id }}</h1>

        <div>
            <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $order->user->name ?? 'Tamu' }}</p>
            <p><strong>Status:</strong> {{ $order->status }}</p>
            <p><strong>Total Pesanan:</strong> Rp {{ number_format($order->total, 2, ',', '.') }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address ?? 'N/A' }}</p>
            {{-- Add other order details as needed --}}
        </div>

        <h2>Produk dalam Pesanan:</h2>

        @if ($order->items->count())
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Kuantitas</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td> {{-- Access product name via relasi --}}
                            <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td> {{-- Price at time of order --}}
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada produk dalam pesanan ini.</p>
        @endif

        <a href="{{ route('admin.orders.index') }}" class="back-link">Kembali ke Daftar Pesanan</a>

    </div>
</body>
</html> 