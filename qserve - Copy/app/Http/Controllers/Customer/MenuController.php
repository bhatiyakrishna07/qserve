<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FoodItem;
use App\Models\Table;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Get table from QR code URL parameter
        $tableId = $request->query('table');
        $table   = null;

        if ($tableId) {
            $table = Table::find($tableId);
        }

        // If no valid table, show error
        if (!$table) {
            return view('customer.invalid-table');
        }

        // Get all active categories with available food items
        $categories = Category::where('is_active', 1)
            ->with(['foodItems' => function ($query) {
                $query->where('is_available', 1);
            }])
            ->get()
            ->filter(fn($cat) => $cat->foodItems->count() > 0);

        return view('customer.menu', compact('table', 'categories'));
    }

    public function landing()
    {
        $categories = Category::where('is_active', 1)
            ->with(['foodItems' => function ($query) {
                $query->where('is_available', 1);
            }])
            ->get()
            ->filter(fn($cat) => $cat->foodItems->count() > 0);

        return view('customer.landing', compact('categories'));
    }
}