<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']) ?: 'category-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('status', 'تم إضافة الفئة.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('categories', 'public');
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('status', 'تم تحديث الفئة.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('status', 'تم حذف الفئة.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
    }
}
