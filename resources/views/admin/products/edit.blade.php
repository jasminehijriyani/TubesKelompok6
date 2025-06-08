<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Produk</title>
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
            max-width: 800px;
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
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="text"], .form-group input[type="number"], .form-group textarea {
            width: calc(100% - 24px);
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        .form-group input[type="text"]:focus, .form-group input[type="number"]:focus, .form-group textarea:focus {
            border-color: #6a11cb;
            outline: none;
        }
        button {
            display: inline-block;
            padding: 12px 20px;
            background: linear-gradient(to right, #ffc107, #ffa000); /* Warna edit */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: opacity 0.3s ease;
        }
        button:hover {
            opacity: 0.9;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #6a11cb;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .current-image {
            margin-top: 10px;
            max-width: 150px;
            height: auto;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Produk: {{ $product->name }}</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Use PUT method for update --}}

            {{-- Display validation errors --}}
            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Judul Buku:</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $product->name) }}">
                @error('name')
                    <div style="color: red; font-size: 0.8em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                 @error('description')
                    <div style="color: red; font-size: 0.8em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image Upload Field --}}
            <div class="form-group">
                <label for="image">Gambar Produk:</label>
                <input type="file" id="image" name="image" accept="image/*">
                @error('image')
                    <div style="color: red; font-size: 0.8em; margin-top: 5px;">{{ $message }}</div>
                @enderror

                {{-- Display current image if exists --}}
                @if ($product->image)
                    <p style="margin-top: 10px; margin-bottom: 5px;">Gambar saat ini:</p>
                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name ?? 'Gambar Produk' }}" class="current-image">
                @endif
            </div>

            <div class="form-group">
                <label for="price">Harga:</label>
                <input type="number" id="price" name="price" step="0.01" required value="{{ old('price', $product->price) }}">
                 @error('price')
                    <div style="color: red; font-size: 0.8em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">Stok:</label>
                <input type="number" id="stock" name="stock" required value="{{ old('stock', $product->stock) }}">
                 @error('stock')
                    <div style="color: red; font-size: 0.8em; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Update Produk</button>
        </form>

        {{-- -Button kembali ke halaman daftar produk --}}
        <a href="{{ route('admin.products.index') }}" class="back-link">Kembali ke Daftar Produk</a>

    </div>
</body>
</html> 