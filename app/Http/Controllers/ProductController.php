<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search    = trim($request->input('search', ''));
        $catFilter = (int) $request->input('category', 0);

        $query = Product::with('category')
            ->when($search, fn($q) =>
                $q->where(fn($q2) =>
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('description', 'like', "%{$search}%")
                )
            )
            ->when($catFilter, fn($q) => $q->where('category_id', $catFilter))
            ->latest();

        $products   = $query->get();
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'search', 'catFilter'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:150',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'nullable|string',
            'cost_price'     => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level'  => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive',
        ], [
            'selling_price.min' => 'Selling price must be greater than 0.',
        ]);

        // treat "0" category_id as null
        if (empty($data['category_id'])) {
            $data['category_id'] = null;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('msg', 'saved');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:150',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'nullable|string',
            'cost_price'     => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level'  => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive',
        ]);

        if (empty($data['category_id'])) {
            $data['category_id'] = null;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('msg', 'saved');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('msg', 'deleted');
    }
}