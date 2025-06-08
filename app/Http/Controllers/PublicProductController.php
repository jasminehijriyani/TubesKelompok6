<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicProductController extends Controller
{
    /**
     * Display listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::all(); // Fetch all products
        $cart = $request->session()->get('cart', []); // Get cart data from session

        return view('public.products.index', compact('products', 'cart')); // Pass products and cart to the public view
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Get cart data from session, default to empty array if not exists
        $cart = session('cart', []);

        return view('public.products.show', compact('product', 'cart')); // Pass the specific product and cart to the public show view
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        // Get the current cart from the session
        $cart = $request->session()->get('cart', []);

        // Add the product to the cart or update quantity if it already exists
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $quantity,
                'name' => $product->name,
                'price' => $product->price,
                // You might store other product details here if needed
            ];
        }

        // Store the updated cart back in the session
        $request->session()->put('cart', $cart);

        // Redirect back to the product page or to a cart page
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Display the cart contents.
     */
    public function showCart(Request $request)
    {
        $cart = $request->session()->get('cart', []); // Get cart data from session

        return view('public.cart.index', compact('cart')); // Pass cart data to the cart view
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            $request->session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Kuantitas produk berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    /**
     * Remove a product from the cart.
     */
    public function removeFromCart(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Remove the item
            $request->session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    /**
     * Display the current user's order history.
     */
    // Removed this method, moved to CustomerOrderController
}
