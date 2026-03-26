<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $categories = Category::when($search, fn($q) =>
                $q->where('name', 'like', "%{$search}%")
            )
            ->latest()
            ->get();

        return view('categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        Category::create($request->only('name', 'description', 'status'));

        return redirect()->route('categories.index')->with('msg', 'saved');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $category->update($request->only('name', 'description', 'status'));

        return redirect()->route('categories.index')->with('msg', 'saved');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('msg', 'deleted');
    }
}