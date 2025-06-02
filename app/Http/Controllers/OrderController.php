<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import the Order model
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch all orders from the database
        $orders = Order::all();

        // Return the view and pass the orders data
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order) // Use Route Model Binding
    {
        // Load the order items and their related products
        $order->load('items.product');

        // Return the view and pass the order data
        return view('admin.orders.show', compact('order'));
    }
}
