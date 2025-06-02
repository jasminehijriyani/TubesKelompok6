<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Produk</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Match background */
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
             min-height: 100vh; /* Ensure gradient covers full height */
        }
        .container {
            max-width: 1200px;
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
        .add-button {
            display: inline-block;
            background: linear-gradient(to right, #28a745, #218838); /* Green gradient */
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: opacity 0.3s ease;
        }
        .add-button:hover {
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #ffffff; /* Solid background for table */
            border-radius: 8px;
            overflow: hidden; /* Hide overflow for rounded corners */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px; /* Adjust padding */
            text-align: left;
        }
        th {
            background-color: #f8f9fa; /* Light background for header */
            color: #555; /* Darker text for header */
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Zebra striping for rows */
        }
        .actions a {
            margin-right: 10px; /* Increase space */
            text-decoration: none;
            color: #6a11cb; /* Match link color */
             transition: color 0.3s ease;
        }
         .actions a:hover {
             color: #2575fc; /* Match hover color */
            text-decoration: underline;
        }
        .actions form {
            display: inline;
        }
        .actions button {
            background: none;
            border: none;
            color: #dc3545; /* Red color for delete */
            cursor: pointer;
            padding: 0;
            margin: 0;
            font-size: inherit;
            transition: color 0.3s ease;
        }
         .actions button:hover {
            color: #c82333; /* Darker red on hover */
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manajemen Produk</h1>
        
        <a href="{{ route('admin.products.create') }}" class="add-button">Tambah Produk Baru</a> {{-- Link to create page --}}

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cover</th>
                    <th>Judul Buku</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop through products here --}}
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name ?? 'Tidak Ada Gambar' }}" style="width: 50px; height: auto; border-radius: 5px;">
                            @else
                                Tidak Ada Gambar
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.products.show', $product->id) }}">Lihat</a> {{-- Link to show page --}}
                            <a href="{{ route('admin.products.edit', $product->id) }}">Edit</a> {{-- Link to edit page --}}
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"> {{-- Form for delete --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Message if no products --}}
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada produk.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</body>
</html> 