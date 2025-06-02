<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
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
        .profile-info {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff; /* Solid background */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .profile-info p {
            margin: 10px 0;
        }
        .profile-info strong {
            color: #555;
            min-width: 150px;
            display: inline-block;
        }
        .nav-links {
            margin-top: 20px;
            display: flex;
            gap: 15px;
        }
        .nav-links a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .nav-links a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .logout-form {
            display: inline;
        }
        .logout-form button {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 0;
            font: inherit;
        }
        .logout-form button:hover {
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
        <div style="margin-bottom: 20px;">
            <a href="{{ route('public.products.index') }}" class="back-link">Kembali ke Daftar Produk</a>
        </div>

        <div class="profile-section">
            <h1>Profil Saya</h1>
            
            <div class="profile-info">
                <div class="info-group">
                    <label>Nama:</label>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                
                <div class="info-group">
                    <label>Email:</label>
                    <span>{{ auth()->user()->email }}</span>
                </div>
                
                <div class="info-group">
                    <label>Alamat:</label>
                    <span>{{ auth()->user()->address ?? 'Belum diisi' }}</span>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('public.orders.history') }}" class="action-button">Lihat Riwayat Pesanan</a>
            </div>
        </div>
    </div>
</body>
</html> 