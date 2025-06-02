<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
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
        .product-detail {
            display: flex;
            gap: 30px;
            flex-wrap: wrap; /* Allow wrapping on small screens */
        }
        .product-image {
            flex: 1; /* Allow image section to grow */
            min-width: 300px; /* Minimum width for image section */
             max-width: 400px; /* Max width for image section */
        }
        .product-image img {
            display: block; /* Remove extra space below image */
            width: 100%; /* Make image take full width of its container */
            max-height: 400px; /* Set a maximum height */
            height: auto; /* Let height adjust proportionally */
            object-fit: cover; /* Cover the area while maintaining aspect ratio */
            border-radius: 8px; /* Match border radius */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); /* Add subtle shadow */
        }
        .product-info {
            flex: 2; /* Allow info section to grow larger */
        }
        .product-info h1 {
            margin-top: 0;
             border-bottom: none; /* Remove border for h1 in info section */
             padding-bottom: 0; /* Remove padding for h1 in info section */
             margin-bottom: 10px; /* Adjust margin */
            color: #333;
        }
        .product-info p {
            margin-bottom: 10px;
        }
        .product-info .price {
            font-size: 1.4em;
            color: #28a745;
            font-weight: bold;
            margin-bottom: 15px;
        }
        /* Styles for Top Navigation (Matching Product Index) */
         .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8鸣px;
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
    </style>
</head>
<body>
    <div class="container">

        {{-- Top Navigation for Cart, Orders, Profile, Logout --}}
        @auth {{-- Only show navigation if user is logged in --}}
        <div class="top-nav"> {{-- Use class for styling --}}
             <h1>Detail Produk</h1> {{-- Or Product Name --}}
              <div>
                  <a href="{{ route('public.products.index') }}">Daftar Produk</a>
                  {{-- Need cart count here if we pass cart data --}}
                  <a href="{{ route('public.cart.index') }}">Keranjang ({{ count($cart) }})</a>
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
          {{-- Separator --}}
         <div style="border-top: 1px solid #ddd; margin-bottom: 20px;"></div>
        @endauth

        @guest {{-- Show simple back link if not logged in --}}
         <div style="margin-bottom: 20px;">
             <a href="{{ route('public.products.index') }}" class="back-link">Kembali ke Daftar Produk</a>
         </div>
        @endguest

        @if (isset($product))
            <div class="product-detail">
                <div class="product-image"> {{-- Wrap image in a div --}}
                    @if ($product->image)
                         <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name ?? 'Gambar Produk' }}">
                    @else
                         <img src="{{ asset('placeholder.png') }}" alt="Tidak Ada Gambar">
                    @endif
                </div> {{-- End image div --}}

                <div class="product-info">
                    <h2>{{ $product->name }}</h2>
                    <p class="price">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                    <p>Stok: {{ $product->stock }}</p>
                    <p class="description">{{ $product->description }}</p>

                    {{-- Container for action buttons --}}
                    <div class="action-buttons-container" style="display: flex; gap: 15px; margin-top: 20px; align-items: flex-start;">
                        {{-- Add to Cart Form --}}
                        <form action="{{ route('public.cart.add') }}" method="POST" style="display: flex; align-items: center;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div style="margin-right: 10px;">
                                <label for="quantity">Jumlah:</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                            <button type="submit" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em;">Tambah ke Keranjang</button>
                        </form>

                        {{-- Buy Now Form --}}
                        <form id="buyNowForm" action="{{ route('public.checkout.buy-now') }}" method="POST" style="display: flex; align-items: center;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="buy_quantity" value="1">
                            <button type="submit" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em;">Beli Sekarang</button>
                        </form>
                    </div> {{-- End action-buttons-container --}}
                </div>
            </div>
        @else
            <p>Produk tidak ditemukan.</p>
        @endif

        {{-- Back link at the bottom for consistency --}}
        @auth
         <div style="margin-top: 20px;">
             <a href="{{ route('public.products.index') }}" class="back-link">Kembali ke Daftar Produk</a>
         </div>
        @endauth

    </div>

    <script>
        // Add event listener to the Buy Now form
        document.addEventListener('DOMContentLoaded', function() {
            const buyNowForm = document.getElementById('buyNowForm');

            if (buyNowForm) {
                buyNowForm.addEventListener('submit', function(event) {
                    // Find the quantity input
                    const quantityInput = document.getElementById('quantity');

                    // Find the hidden buy_quantity input in the current form
                    const buyQuantityInput = buyNowForm.querySelector('input[name="quantity"]');

                    if (quantityInput && buyQuantityInput) {
                        // Update the hidden quantity input with the value from the quantity input
                        buyQuantityInput.value = quantityInput.value;
                    }

                    // The form will submit automatically after this
                });
            }
        });
    </script>
</body>
</html> 