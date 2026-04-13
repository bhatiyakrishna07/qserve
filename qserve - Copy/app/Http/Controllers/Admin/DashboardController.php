<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\FoodItem;
use App\Models\Category;
use App\Models\Table;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_orders'     => Order::count(),
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'total_food_items' => FoodItem::count(),
            'total_tables'     => Table::count(),
            'total_categories' => Category::count(),
            'recent_orders'    => Order::with('table')
                                    ->latest()
                                    ->take(5)
                                    ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}