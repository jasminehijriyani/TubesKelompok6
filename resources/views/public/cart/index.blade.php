<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
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
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .top-nav h1 {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
            color: #333;
        }
        .top-nav a {
            color: #007bff;
            text-decoration: none;
            margin-left: 20px;
            transition: color 0.3s ease;
        }
        .top-nav a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .top-nav .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .top-nav .user-menu form {
            margin: 0;
        }
        .top-nav .user-menu button {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 0;
            font: inherit;
        }
        .top-nav .user-menu button:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: rgba(106, 17, 203, 0.05);
        }
        .total-row td {
            font-weight: bold;
            border-top: 2px solid #6a11cb;
        }
        input[type="number"] {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        input[type="number"]:focus {
            border-color: #6a11cb;
            outline: none;
        }
        button[type="submit"] {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }
        button[type="submit"]:hover {
            opacity: 0.9;
        }
        .checkout-section {
            margin-top: 30px;
            text-align: right;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .checkout-section button {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: opacity 0.3s ease;
        }
        .checkout-section button:hover {
            opacity: 0.9;
        }
        .empty-cart {
            text-align: center;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .empty-cart p {
            color: #666;
            margin-bottom: 15px;
        }
        .back-link {
            display: inline-block;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .cart-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cart-actions form {
            margin: 0;
        }
        .cart-actions button.update {
            background: #28a745;
        }
        .cart-actions button.remove {
            background: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <body>
    <div class="container">

        {{-- Flash Message --}}
        @if (session('success'))
            <div style="color: green; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="color: red; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        {{-- Lanjutkan isi halaman... --}}

        @auth
        <div class="top-nav">
            <h1>Keranjang Belanja</h1>
            <div>
                <a href="{{ route('public.products.index') }}">Daftar Produk</a>
                <a href="{{ route('public.orders.history') }}">Riwayat Pesanan</a>
            </div>
            <div class="user-menu">
                <a href="{{ route('public.profile') }}">Profil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </div>
        </div>
        @endauth

        @guest
        <div style="margin-bottom: 20px;">
            <a href="{{ route('public.products.index') }}" class="back-link">Kembali ke Daftar Produk</a>
        </div>
        @endguest

        @if (isset($cart) && count($cart) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach ($cart as $id => $details)
                        <tr>
                            <td>{{ $details['name'] }}</td>
                            <td>Rp {{ number_format($details['price'], 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('public.cart.update', $id) }}" method="POST" class="cart-actions">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1">
                                    <button type="submit" class="update">Perbarui</button>
                                </form>
                            </td>
                            <td>Rp {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('public.cart.remove', $id) }}" method="POST" class="cart-actions">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @php $grandTotal += $details['price'] * $details['quantity']; @endphp
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Total Keseluruhan:</td>
                        <td>Rp {{ number_format($grandTotal, 2, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <div class="checkout-section">
                @guest
                    <p style="color: #dc3545; margin-bottom: 15px;">Silakan masuk untuk melanjutkan pembayaran.</p>
                    <a href="{{ route('login') }}" class="back-link" style="margin-right: 10px;">Masuk</a>
                @endguest

                @auth
                    <form action="{{ route('public.checkout.process') }}" method="POST">
                    @csrf
                    <button type="submit">Bayar</button>
                </form>
                @endauth
            </div>

        @else
            <div class="empty-cart">
                <p>Keranjang belanja Anda kosong.</p>
                <a href="{{ route('public.products.index') }}" class="back-link">Lanjut Belanja</a>
            </div>
        @endif

        @guest
        <div style="margin-top: 20px;">
            <a href="{{ route('public.products.index') }}" class="back-link">Lanjut Belanja</a>
        </div>
        @endguest
    </div>
</body>
</html> 