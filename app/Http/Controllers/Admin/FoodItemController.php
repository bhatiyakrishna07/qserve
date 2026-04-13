<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodItemController extends Controller
{
    public function index()
    {
        $foodItems = FoodItem::with('category')->latest()->paginate(10);
        return view('admin.food-items.index', compact('foodItems'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('admin.food-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:191',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('food-items', 'public');
        }

        FoodItem::create([
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'price'        => $request->price,
            'image'        => $imagePath,
            'is_available' => $request->has('is_available') ? 1 : 0,
        ]);

        return redirect()->route('admin.food-items.index')
                         ->with('success', 'Food item created successfully!');
    }

    public function edit(FoodItem $foodItem)
    {
        $categories = Category::where('is_active', 1)->get();
        return view('admin.food-items.edit', compact('foodItem', 'categories'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:191',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $foodItem->image;
        if ($request->hasFile('image')) {
            if ($foodItem->image) {
                Storage::disk('public')->delete($foodItem->image);
            }
            $imagePath = $request->file('image')->store('food-items', 'public');
        }

        $foodItem->update([
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'price'        => $request->price,
            'image'        => $imagePath,
            'is_available' => $request->has('is_available') ? 1 : 0,
        ]);

        return redirect()->route('admin.food-items.index')
                         ->with('success', 'Food item updated successfully!');
    }

    public function destroy(FoodItem $foodItem)
    {
        if ($foodItem->image) {
            Storage::disk('public')->delete($foodItem->image);
        }
        $foodItem->delete();

        return redirect()->route('admin.food-items.index')
                         ->with('success', 'Food item deleted successfully!');
    }
}