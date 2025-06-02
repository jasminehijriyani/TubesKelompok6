<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import Order model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class CustomerOrderController extends Controller
{
    /**
     * Display the current user's order history.
     */
    public function showMyOrders()
    {
        // Get the authenticated user's orders
        // Assuming User model has a hasMany Orders relationship and eager loading items with products
        $orders = Auth::user()->orders()->with('items.product')->get(); 

        // Get cart data from session, default to empty array if not exists
        $cart = session('cart', []);

        // Return the view and pass the orders and cart
        return view('public.orders.history', compact('orders', 'cart'));
    }

    /**
     * Display the specified order for the authenticated user.
     */
    public function show(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.'); // Or redirect with an error message
        }

        // Load the order items and their related products
        $order->load('items.product');

        // Return the view and pass the order data
        return view('public.orders.show', compact('order'));
    }

    /**
     * Display the customer's profile.
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('public.profile', compact('user'));
    }

    // Add method for showing public order detail next
}
