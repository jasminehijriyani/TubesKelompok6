<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Process the checkout.
     */
    public function process(Request $request)
    {
        // Debugging awal: cek apakah method ini terpanggil
        // dd('Proses checkout dipanggil');
        
        // Pastikan user sudah login (auth user publik, bukan admin)
        if (!Auth::check()) {
            // Redirect ke halaman login user (bukan admin)
            return redirect()->route('login')->with('error', 'Mohon login untuk melanjutkan checkout.');
        }

        // Ambil data cart dari session
        $cart = $request->session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('public.cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => 0, // total dihitung nanti
                'status' => 'pending',
                'shipping_address' => Auth::user()->address ?? null,
            ]);

            $grandTotal = 0;

            foreach ($cart as $id => $details) {
                $product = Product::find($id);

                if (!$product || $product->stock < $details['quantity']) {
                    DB::rollBack();
                    return redirect()->route('public.cart.index')->with('error', 'Stok tidak mencukupi untuk salah satu produk.');
                }

                OrderItem::create([ //Menyimpan item pesanan ke database dengan detail order, produk, jumlah, dan harga
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $details['quantity'],
                    'price' => $product->price,
                ]);

                // Kurangi stok produk
                $product->stock -= $details['quantity'];
                $product->save();

                $grandTotal += $product->price * $details['quantity'];
            }

            // Update total order
            $order->total = $grandTotal;
            $order->save();

            // Bersihkan cart session
            $request->session()->forget('cart');

            // Commit transaksi
            DB::commit();

            return redirect()->route('public.orders.history')->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            // Kamu bisa log error $e->getMessage() di sini jika perlu

            return redirect()->route('public.cart.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());

        }
    }

    /**
     * Show confirmation page for 'Buy Now' product.
     */
    public function showBuyNowConfirmation(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Mohon login untuk melanjutkan pembelian.');
        }

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);
        $quantity = $validatedData['quantity'];

        return view('public.checkout.buy-now-confirm', compact('product', 'quantity'));
    }

    /**
     * Finalize the 'Buy Now' purchase.
     */
    public function finalizeBuyNow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Mohon login untuk melanjutkan pembelian.');
        }

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);
        $quantity = $validatedData['quantity'];

        if ($product->stock < $quantity) {
            return redirect()->route('public.products.show', $product->id)->with('error', 'Stok tidak mencukupi untuk produk ini.');
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $product->price * $quantity,
                'status' => 'pending',
                'shipping_address' => Auth::user()->address ?? null,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);

            $product->stock -= $quantity;
            $product->save();

            DB::commit();

            return redirect()->route('public.orders.show', $order->id)->with('success', 'Pembelian berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('public.products.show', $product->id)
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pembelian: ' . $e->getMessage());
        }
    }

    /**
     * Redirect 'Buy Now' request to confirmation page.
     */
    public function buyNow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Mohon login untuk melanjutkan pembelian.');
        }

        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return redirect()->route('public.checkout.buy-now.confirm')->withInput($validatedData);
    }
}
