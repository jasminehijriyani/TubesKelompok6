<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <style>
        /* --- Public Theme Styles (Matching Product Index) --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Public background */
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
             min-height: 100vh; /* Ensure gradient covers full height */
        }
        .container {
            max-width: 1200px; /* Match container width */
            margin: 20px auto; /* Add some margin top/bottom */
            background: rgba(255, 255, 255, 0.9); /* Match container style */
            padding: 30px; /* Adjust padding */
            border-radius: 10px; /* Match border radius */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Match shadow */
            backdrop-filter: blur(5px); /* Add blur effect */
        }
        h1 {
            color: #333; /* Darken heading color */
            border-bottom: 2px solid #6a11cb; /* Match border color */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        /* Styles for Tables (Matching Admin/Product Index Table Style) */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #ffffff; /* Solid background for table */
            border-radius: 8px; /* Match border radius */
            overflow: hidden; /* Hide overflow for rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); /* Add subtle shadow */
        }
        th, td {
            border: 1px solid #ddd; /* Match border */
            padding: 12px; /* Match padding */
            text-align: left;
        }
        th {
            background-color: #f8f9fa; /* Match header background */
            color: #555; /* Match header color */
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Zebra striping */
        }
         .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }
        .actions a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
         .back-link {
             display: inline-block;
             margin-top: 20px;
             color: #007bff;
             text-decoration: none;
             transition: color 0.3s ease;
         }
         .back-link:hover {
             color: #0056b3;
             text-decoration: underline;
         }
        /* Styles for Top Navigation (Matching Product Index) */
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
             margin-bottom: 0; /* Remove bottom margin from heading */
             border-bottom: none; /* Remove border from heading in nav */
             padding-bottom: 0; /* Remove padding from heading in nav */
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
    </style>
</head>
<body>
    <div class="container">
        <div class="top-nav">
            <h1>Riwayat Pesanan</h1>
            <div>
                <a href="{{ route('public.cart.index') }}">
                    Keranjang ({{ count($cart) }})
                </a>
                <a href="{{ route('public.products.index') }}">Daftar Produk</a>
            </div>
            <div class="user-menu">
                <a href="{{ route('public.profile') }}">Profil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </div>
        </div>

        <div style="border-top: 1px solid #ddd; margin-bottom: 20px;"></div>

        @forelse ($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <h3>Pesanan #{{ $order->id }}</h3>
                <span class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="order-items">
                @foreach ($order->items as $item)
                <div class="order-item">
                    <span class="item-name">{{ $item->product->name }}</span>
                    <span class="item-quantity">x{{ $item->quantity }}</span>
                    <span class="item-price">Rp {{ number_format($item->price, 2, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
            <div class="order-footer">
                <span class="order-total">Total: Rp {{ number_format($order->total, 2, ',', '.') }}</span>
                <a href="{{ route('public.orders.show', $order->id) }}" class="view-details">Lihat Detail</a>
            </div>
        </div>
        @empty
        <div class="no-orders">
            Belum ada pesanan yang dibuat.
        </div>
        @endforelse
    </div>
</body>
</html> 