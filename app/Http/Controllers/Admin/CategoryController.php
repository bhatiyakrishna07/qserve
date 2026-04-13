<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:191|unique:categories,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name'      => $request->name,
            'image'     => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required|string|max:191|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name'      => $request->name,
            'image'     => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Delete food item images first
        foreach ($category->foodItems as $item) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
        }

        // Delete all related food items
        $category->foodItems()->delete();

        // Delete category image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        // Delete category
        $category->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category and its food items deleted successfully!');
    }
}