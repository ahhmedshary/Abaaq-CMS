<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with('category')->orderBy('sort_order')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'تم إضافة المنتج.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($data['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        }

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'تم تحديث المنتج.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('status', 'تم حذف المنتج.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'compare_price' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:4096',
            'is_featured' => 'nullable|boolean',
            'is_on_offer' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        unset($data['image']);
        return array_merge($request->only(['category_id', 'name', 'description', 'price', 'compare_price', 'stock', 'sort_order']), [
            'is_featured' => $request->boolean('is_featured'),
            'is_on_offer' => $request->boolean('is_on_offer'),
            'is_published' => $request->boolean('is_published'),
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'product';
        $slug = $base;
        $i = 1;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
