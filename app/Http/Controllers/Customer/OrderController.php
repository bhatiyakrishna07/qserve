<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\FoodItem;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'table_id'      => 'required|exists:tables,id',
            'customer_name' => 'nullable|string|max:191',
            'notes'         => 'nullable|string',
            'items'         => 'required|array|min:1',
            'items.*.id'    => 'required|exists:food_items,id',
            'items.*.qty'   => 'required|integer|min:1',
        ]);

        $table = Table::findOrFail($request->table_id);

        // Check if active order already exists for this table
        // Active = any status that is NOT served or cancelled
        $existingOrder = Order::where('table_id', $table->id)
            ->whereNotIn('status', ['served', 'cancelled'])
            ->latest()
            ->first();

        // Calculate items
        $newItemsTotal  = 0;
        $orderItemsData = [];

        foreach ($request->items as $item) {
            $foodItem  = FoodItem::findOrFail($item['id']);
            $subtotal  = $foodItem->price * $item['qty'];
            $newItemsTotal += $subtotal;

            $orderItemsData[] = [
                'food_item_id' => $foodItem->id,
                'quantity'     => $item['qty'],
                'price'        => $foodItem->price,
                'notes'        => $item['notes'] ?? null,
            ];
        }

        if ($existingOrder) {
            // ✅ Add items to existing order
            foreach ($orderItemsData as $itemData) {

                // If same food item already exists in order → increase quantity
                $existingItem = $existingOrder->orderItems()
                    ->where('food_item_id', $itemData['food_item_id'])
                    ->first();

                if ($existingItem) {
                    $existingItem->increment('quantity', $itemData['quantity']);
                } else {
                    $existingOrder->orderItems()->create($itemData);
                }
            }

            // Update total amount
            $existingOrder->update([
                'total_amount'  => $existingOrder->total_amount + $newItemsTotal,
                'status'        => 'pending', // reset to pending for kitchen
            ]);

            return redirect()->route('customer.order.confirmation', $existingOrder->id)->with('order_updated', true);

        } else {
            // ✅ Create brand new order
            $order = Order::create([
                'table_id'      => $table->id,
                'customer_name' => $request->customer_name ?? 'Guest',
                'total_amount'  => $newItemsTotal,
                'status'        => 'pending',
                'notes'         => $request->notes,
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->orderItems()->create($itemData);
            }

            // Mark table as occupied
            $table->update(['status' => 'occupied']);

            return redirect()->route('customer.order.confirmation', $order->id)->with('order_updated', false);
        }
    }

    public function confirmation($orderId)
    {
        $order = Order::with(['orderItems.foodItem', 'table'])
                      ->findOrFail($orderId);

        return view('customer.confirmation', compact('order'));
    }
}