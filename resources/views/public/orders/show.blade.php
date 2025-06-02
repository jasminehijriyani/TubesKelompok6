<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
     <style>
         /* --- Public Theme Styles (Matching Product Index) --- */
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
          h2 {
             color: #555;
             margin-top: 20px;
             margin-bottom: 10px;
             border-bottom: 1px solid #ddd;
             padding-bottom: 5px;
          }
         /* Styles for Tables (Matching Admin/Product Index Table Style) */
         table {
             width: 100%;
             border-collapse: collapse;
             margin-top: 20px;
             background: #ffffff;
             border-radius: 8px;
             overflow: hidden;
             box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
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
              margin-bottom: 0;
              border-bottom: none;
              padding-bottom: 0;
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

         {{-- Top Navigation for Cart, Orders, Profile, Logout --}}
         @auth {{-- Only show navigation if user is logged in --}}
         <div class="top-nav"> {{-- Use class for styling --}}
             <h1>Detail Pesanan</h1>
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
          {{-- Separator --}}
         <div style="border-top: 1px solid #ddd; margin-bottom: 20px;"></div>
         @endauth

         @guest {{-- Show simple back link if not logged in --}}
          <div style="margin-bottom: 20px;">
              <a href="{{ route('public.orders.history') }}" class="back-link">Kembali ke Riwayat Pesanan</a>
          </div>
         @endguest


         <div class="order-detail">
             <div class="order-header">
                 <h2>Pesanan #{{ $order->id }}</h2>
                 <div class="order-info">
                     <p>Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                     <p>Status: {{ $order->status }}</p>
                 </div>
             </div>

             <div class="order-items">
                 <h3>Item Pesanan</h3>
                 @foreach ($order->items as $item)
                 <div class="order-item">
                     <div class="item-info">
                         <span class="item-name">{{ $item->product->name }}</span>
                         <span class="item-quantity">x{{ $item->quantity }}</span>
                     </div>
                     <span class="item-price">Rp {{ number_format($item->price, 2, ',', '.') }}</span>
                 </div>
                 @endforeach
             </div>

             <div class="order-summary">
                 <h3>Ringkasan Pesanan</h3>
                 <div class="summary-row">
                     <span>Subtotal</span>
                     <span>Rp {{ number_format($order->total, 2, ',', '.') }}</span>
                 </div>
                 <div class="summary-row">
                     <span>Total</span>
                     <span class="total">Rp {{ number_format($order->total, 2, ',', '.') }}</span>
                 </div>
             </div>

             <div class="order-actions">
                 <a href="{{ route('public.orders.history') }}" class="back-button">Kembali ke Riwayat Pesanan</a>
             </div>
         </div>

     </div>
 </body>
 </html> 