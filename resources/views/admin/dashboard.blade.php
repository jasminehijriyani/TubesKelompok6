<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            margin: 20px auto; /* Add some margin top/bottom */
            background: rgba(255, 255, 255, 0.9);
            padding: 30px; /* Adjust padding */
            border-radius: 10px; /* Match border radius */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px); /* Add blur effect */
        }
        h1 {
            color: #333; /* Darken heading color */
            border-bottom: 2px solid #6a11cb; /* Match border color with gradient */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        h3 {
             color: #555; /* Style for subheadings */
             margin-top: 20px;
             margin-bottom: 10px;
             border-bottom: 1px solid #ddd;
             padding-bottom: 5px;
        }
        p {
            margin-bottom: 15px;
        }
        .welcome-message {
            font-size: 1.1em;
            margin-bottom: 20px;
            color: #555; /* Darken welcome message color */
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        ul li a {
            color: #6a11cb; /* Match link color with theme */
            text-decoration: none;
            transition: color 0.3s ease;
        }
        ul li a:hover {
            color: #2575fc; /* Match hover color */
            text-decoration: underline;
        }
         form button {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(to right, #e74c3c, #c0392b); /* Reddish gradient for logout */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: opacity 0.3s ease;
        }
        form button:hover {
            opacity: 0.9;
        }

        /* Styles for Summary Widgets */
        .summary-widgets {
            display: flex;
            justify-content: space-around; /* Distribute cards evenly */
            margin-top: 30px;
            flex-wrap: wrap; /* Allow cards to wrap on smaller screens */
            gap: 20px; /* Space between cards */
        }

        .widget-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            width: 250px; /* Adjust width as needed */
            min-width: 200px;
            transition: transform 0.3s ease;
        }

        .widget-card:hover {
            transform: translateY(-5px);
        }

        .widget-icon {
            font-size: 2.5em; /* Make icon larger */
            margin-right: 15px;
            color: #6a11cb; /* Match theme color */
        }

        .widget-details {
            text-align: left;
        }

        .widget-title {
            font-size: 1em;
            color: #555;
            margin-bottom: 5px;
        }

        .widget-value {
            font-size: 1.5em; /* Make value larger */
            font-weight: bold;
            color: #333;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p class="welcome-message">Selamat datang!</p>
{{--        <p>Ini adalah halaman dashboard admin. Di sini Anda akan menemukan ringkasan data, statistik, dan navigasi ke berbagai fitur manajemen e-commerce.</p>--}}
{{--        <p>Fungsionalitas tambahan seperti manajemen produk, pesanan, pengguna, dll. akan ditambahkan di sini.</p>--}}
        
        <!-- Summary Widgets -->
        <div class="summary-widgets">
            <div class="widget-card">
                <div class="widget-icon">📦</div> {{-- Placeholder Icon --}}
                <div class="widget-details">
                    <div class="widget-title">Produk</div>
                    <div class="widget-value">110</div>
                </div>
            </div>

            <div class="widget-card">
                <div class="widget-icon">🛒</div> {{-- Placeholder Icon --}}
                <div class="widget-details">
                    <div class="widget-title">Pesanan Baru</div>
                    <div class="widget-value">241</div>
                </div>
            </div>

            <div class="widget-card">
                <div class="widget-icon">💰</div> {{-- Placeholder Icon --}}
                <div class="widget-details">
                    <div class="widget-title">Pendapatan</div>
                    <div class="widget-value">Rp 432.000.000</div>
                </div>
            </div>
            
            {{-- Add more widgets as needed --}}

        </div>

        <!-- Action Links as Cards -->
{{--        <div class="summary-widgets" style="margin-top: 20px;"> {{-- Reuse summary-widgets class for flex layout --}}
{{--            <div class="widget-card"> {{-- Reuse widget-card class for styling --}}
{{--                 <div class="widget-details" style="text-align: center; width: 100%;"> {{-- Center text and take full width --}}
{{--                    <a href="{{ route('admin.products.index') }}" style="text-decoration: none; color: #333; font-weight: bold;">Manajemen Produk</a>--}}
{{--                 </div>--}}
{{--            </div>--}}

{{--             <div class="widget-card"> {{-- Reuse widget-card class for styling --}}
{{--                 <div class="widget-details" style="text-align: center; width: 100%;"> {{-- Center text and take full width --}}
{{--                     <a href="{{ route('admin.orders.index') }}" style="text-decoration: none; color: #333; font-weight: bold;">Manajemen Pesanan</a> {{-- Use the correct route name --}}
{{--                 </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Dedicated Management Links Section -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;"> {{-- Add some spacing and a separator --}}
            <h3>Area Manajemen</h3>
            <ul style="list-style: none; padding: 0; display: flex; gap: 20px;"> {{-- Use flexbox for horizontal layout --}}
                <li><a href="{{ route('admin.products.index') }}" style="display: inline-block; padding: 10px 15px; background-color: #6a11cb; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">Manajemen Produk</a></li>
                <li><a href="{{ route('admin.orders.index') }}" style="display: inline-block; padding: 10px 15px; background-color: #2575fc; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">Manajemen Pesanan</a></li>
            </ul>
        </div>

        <!-- Basic Logout Form (you can replace this with a proper button/link and POST request) -->
        <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 30px;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html> 