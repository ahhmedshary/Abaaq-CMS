<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Product::where('is_published', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        return view('products.index', [
            'products' => $query->orderBy('sort_order')->paginate(12)->withQueryString(),
            'categories' => Category::orderBy('sort_order')->get(),
            'activeCategory' => $request->category,
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $related = Product::where('is_published', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)->get();

        return view('products.show', compact('product', 'related'));
    }
}
