@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1>Detail Produk</h1>

    <div class="product-detail-card">
        @if ($product->image)
            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name ?? 'Gambar Produk' }}" class="product-image">
        @endif

        <h2>{{ $product->name }}</h2>
        <p><strong>Harga:</strong> Rp {{ number_format($product->price, 2, ',', '.') }}</p>
        <p><strong>Stok:</strong> {{ $product->stock }}</p>
        <p><strong>Deskripsi:</strong> {{ $product->description ?? 'Tidak ada deskripsi.' }}</p>

        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali ke Daftar Produk</a>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Edit Produk</a>
    </div>
</div>

<style>
    .product-detail-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-top: 20px;
    }
    .product-detail-card h2 {
        margin-top: 0;
        color: #333;
    }
    .product-detail-card p {
        margin-bottom: 10px;
        color: #555;
    }
    .product-image {
        max-width: 200px;
        height: auto;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    .btn {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        margin-right: 10px;
        margin-top: 20px;
        cursor: pointer;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: 1px solid #6c757d;
    }
</style>
@endsection 