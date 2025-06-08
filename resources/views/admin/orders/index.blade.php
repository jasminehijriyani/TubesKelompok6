<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Pesanan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
            min-height: 100vh;
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
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #6a11cb;
            transition: color 0.3s ease;
        }
         .actions a:hover {
             color: #2575fc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manajemen Pesanan</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Alamat Pengiriman</th>
                    {{-- Add more headers as needed --}}
                    <th>Aksi</th> {{-- For view/edit/delete buttons --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order) {{-- -Loop daftar pesanan  --}}
                    <tr>
                        <td>{{ $order->id }}</td> {{-- -Menampilkan ID dari order. --}}
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $order->user->name ?? 'Tamu' }}</td>
                        <td>Rp {{ number_format($order->total, 2, ',', '.') }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ Str::limit($order->shipping_address, 50) ?? 'N/A' }}</td>
                        {{-- Display other order details --}}
                        <td class="actions">
                            {{-- Action buttons like View Details --}}
                            <a href="{{ route('admin.orders.show', $order->id) }}">Lihat Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada pesanan.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</body>
</html> 