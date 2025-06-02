<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import Order model
use App\Models\OrderItem; // Import OrderItem model
use App\Models\Product; // Import Product model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\DB; // Import DB facade for transactions

class CheckoutController extends Controller
{
    /**
     * Process the checkout.
     */
    public function process(Request $request)
    {
        // Ensure user is authenticated (if needed)
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Mohon login untuk melanjutkan checkout.'); // Redirect to login if not authenticated
        }

        $cart = $request->session()->get('cart', []); // Get cart data from session

        if (count($cart) == 0) {
            return redirect()->route('public.cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Start database transaction
        DB::beginTransaction();

        try {
            // Create a new order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => 0, // Calculate total later
                'status' => 'pending',
                // You might add shipping address or other details from request/user profile
                'shipping_address' => Auth::user()->address ?? null, // Assuming user has an address field
            ]);

            $grandTotal = 0;

            // Add items to the order and reduce product stock
            foreach ($cart as $id => $details) {
                $product = Product::find($id);

                // Check if product exists and has enough stock
                if (!$product || $product->stock < $details['quantity']) {
                    DB::rollBack();
                    return redirect()->route('public.cart.index')->with('error', 'Stok tidak mencukupi untuk salah satu produk.');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $details['quantity'],
                    'price' => $product->price, // Store current price
                ]);

                // Reduce product stock
                $product->stock -= $details['quantity'];
                $product->save();

                $grandTotal += $product->price * $details['quantity'];
            }

            // Update the order total
            $order->total = $grandTotal;
            $order->save();

            // Clear the cart from the session
            $request->session()->forget('cart');

            // Commit the transaction
            DB::commit();

            // Redirect to a confirmation page or order history
            // You might want to create a new route and view for order confirmation
            return redirect()->route('public.orders.history')->with('success', 'Pesanan Anda berhasil dibuat!'); // Redirect to customer order history

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            // Log the error ($e->getMessage())
            return redirect()->route('public.cart.index')->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Show the confirmation page for a single 'Buy Now' product.
     */
    public function showBuyNowConfirmation(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Mohon login untuk melanjutkan pembelian.');
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);
        $quantity = $validatedData['quantity'];

        // Pass product and quantity to the confirmation view
        return view('public.checkout.buy-now-confirm', compact('product', 'quantity'));
    }

    /**
     * Finalize the 'Buy Now' purchase after confirmation.
     */
    public function finalizeBuyNow(Request $request)
    {
         // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Mohon login untuk melanjutkan pembelian.');
        }

        // Validate the incoming request data again
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);
        $quantity = $validatedData['quantity'];

        // Check if product has enough stock
        if ($product->stock < $quantity) {
             return redirect()->route('public.products.show', $product->id)->with('error', 'Stok tidak mencukupi untuk produk ini.'); // Redirect back to product detail
        }

         // Start database transaction
        DB::beginTransaction();

        try {
            // Create a new order for this single item
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $product->price * $quantity, // Calculate total immediately
                'status' => 'pending',
                'shipping_address' => Auth::user()->address ?? null,
            ]);

            // Add the item to the order_items table
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price, // Store current price
            ]);

            // Reduce product stock
            $product->stock -= $quantity;
            $product->save();

            // Commit the transaction
            DB::commit();

            // Redirect to the public order detail page
            return redirect()->route('public.orders.show', $order->id)->with('success', 'Pembelian berhasil!');

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            return redirect()->route('public.products.show', $product->id)->withInput()->with('error', 'Terjadi kesalahan saat memproses pembelian: ' . $e->getMessage()); // Redirect back to product detail with error
        }
    }

    // Update the old buyNow method to just redirect to the confirmation page
    public function buyNow(Request $request)
    {
         // Ensure user is authenticated
        if (!Auth::check()) {
             return redirect()->route('login')->with('error', 'Mohon login untuk melanjutkan pembelian.');
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Redirect to the confirmation page with validated data
        return redirect()->route('public.checkout.buy-now.confirm')->withInput($validatedData);
    }

    // You might add methods for showing checkout form (if needed) or confirmation page
}
