<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['table', 'orderItems.foodItem'])
                       ->latest()
                       ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['table', 'orderItems.foodItem']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,served,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        // If served or cancelled, mark table as available
        if (in_array($request->status, ['served', 'cancelled'])) {
            $order->table->update(['status' => 'available']);
        }

        return back()->with('success', 'Order status updated!');
    }

    public function invoice(Order $order)
    {
        $order->load(['table', 'orderItems.foodItem']);
        return view('admin.orders.invoice', compact('order'));
    }
}