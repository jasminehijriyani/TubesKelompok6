<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <style>
        /* --- Admin Theme Styles --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Admin background */
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
             min-height: 100vh; /* Ensure gradient covers full height */
        }
        .container {
            max-width: 1200px; /* Match admin container width */
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
         /* Styles for Product Cards (adapted from admin widgets/tables) */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 0; /* Adjust margin top if needed */
        }
        .product-card {
            border: 1px solid #ddd; /* Match border */
            border-radius: 8px; /* Match border radius */
            padding: 15px;
            text-align: center;
            background-color: #ffffff; /* Solid background */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); /* Match shadow */
             transition: transform 0.3s ease;
        }
         .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            max-width: 100%;
            height: 180px; /* Adjust height */
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .product-card h3 {
            font-size: 1.1em; /* Adjust size */
            margin-bottom: 8px; /* Adjust margin */
            color: #333;
        }
        .product-card p.price {
            font-size: 1em; /* Adjust size */
            color: #28a745;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .product-card a {
            display: inline-block;
             color: #6a11cb; /* Match admin link color */
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
             transition: color 0.3s ease;
        }
         .product-card a:hover {
             color: #2575fc; /* Match admin hover color */
            text-decoration: underline;
        }
         .no-products {
            text-align: center;
            font-size: 1.2em;
            color: #777;
         }

         /* Styles for Action Buttons (Add to Cart, Buy Now) */
         .action-buttons-container {
             margin-top: 10px;
             display: flex;
             align-items: center;
             gap: 10px; /* Space between buttons */
             justify-content: center; /* Center buttons */
         }
         .action-buttons-container form {
             display: flex; /* Make forms flex containers */
             align-items: center;
             margin-top: 0; /* Remove default form margin */
         }
         .action-buttons-container label {
             font-size: 0.9em;
             margin-right: 5px;
         }
          .action-buttons-container input[type="number"] {
             width: 40px;
             padding: 3px;
             border: 1px solid #ddd;
             border-radius: 4px;
             font-size: 0.9em;
             margin-right: 5px; /* Space after input */
          }
          .action-buttons-container button {
              padding: 8px 10px;
              border: none;
              border-radius: 5px;
              cursor: pointer;
              font-size: 0.9em;
              transition: opacity 0.3s ease;
          }
          .action-buttons-container button:hover {
              opacity: 0.9;
          }

         /* Specific button colors */
         .action-buttons-container form button[type="submit"] {
             background-color: #28a745; /* Green for Add to Cart */
             color: white;
         }
         .action-buttons-container form:last-child button[type="submit"] {
              background-color: #007bff; /* Blue for Buy Now */
              color: white;
         }

          /* Styles for Top Navigation (Cart and Orders) */
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

        {{-- Top Navigation for Cart and Orders --}}
        <div class="top-nav"> {{-- Use class for styling --}}
            <h1>Daftar Produk</h1>
            <div>
                {{-- Link to Cart --}}
                <a href="{{ route('public.cart.index') }}">
                    Keranjang ({{ count($cart) }})
                </a>

                {{-- Link to Orders History --}}
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
        <div style="border-top: 1px solid #ddd; margin-bottom: 20px;"></div> {{-- Add a styled separator --}}

        <div class="product-grid">
            {{-- Loop through products here --}}
            @forelse ($products as $product)
            <div class="product-card">
                @if ($product->image)
                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name ?? 'Gambar Produk' }}" width="150">
                @else
                    <p>Tidak ada gambar.</p>
                @endif

                <h3>{{ $product->name }}</h3>
                <p class="price">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                
                {{-- Link to product detail page --}}
                <a href="{{ route('public.products.show', $product->id) }}" style="margin-bottom: 10px; display: inline-block;">Lihat Detail</a> {{-- Added margin-bottom --}}

                {{-- Container for Buy/Add buttons --}}
                <div class="action-buttons-container"> {{-- Use class for styling --}}
                    {{-- Add to Cart Form for Index Page --}}
                    <form action="{{ route('public.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div>
                            <label for="quantity_{{ $product->id }}">Jumlah:</label>
                            <input type="number" id="quantity_{{ $product->id }}" name="quantity" value="1" min="1">
                        </div>
                        <button type="submit">Tambah ke Keranjang</button>
                    </form>

                    {{-- Buy Now Form for Index Page --}}
                    <form action="/checkout/buy-now" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="buy_quantity_{{ $product->id }}" name="quantity" value="1"> {{-- Tambah ID --}}
                    <button type="submit">Beli Sekarang</button>
                </form>

                </div> {{-- End flex container --}}

            </div>
            @empty
             {{-- Message if no products --}}
            <div class="no-products">
                Belum ada produk yang tersedia saat ini.
            </div>
            @endforelse

        </div>
    </div>

    <script>
        // Add event listeners to all "Beli Sekarang" forms
        document.addEventListener('DOMContentLoaded', function() {
            const buyNowForms = document.querySelectorAll('.action-buttons-container form:last-child');

            buyNowForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    // Find the product ID from the hidden input
                    const productIdInput = form.querySelector('input[name="product_id"]');
                    if (!productIdInput) return;

                    const productId = productIdInput.value;

                    // Find the corresponding quantity input for this product
                    const quantityInput = document.getElementById('quantity_' + productId);

                    // Find the hidden buy_quantity input in the current form
                    const buyQuantityInput = form.querySelector('input[name="quantity"][id^="buy_quantity_"]');

                    if (quantityInput && buyQuantityInput) {
                        // Update the hidden quantity input with the value from the quantity input
                        buyQuantityInput.value = quantityInput.value;
                    }

                    // The form will submit automatically after this
                });
            });
        });
    </script>
</body>
</html> 