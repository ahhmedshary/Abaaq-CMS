@extends('admin.layouts.app')
@section('title', $product->exists ? 'تعديل منتج' : 'منتج جديد')

@section('content')
<form method="POST"
  action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
  enctype="multipart/form-data" class="space-y-5">
  @csrf
  @if ($product->exists) @method('PUT') @endif

  <div>
    <label class="text-sm text-muted block mb-1">اسم المنتج</label>
    <input name="name" value="{{ old('name', $product->name) }}" required
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="text-sm text-muted block mb-1">الفئة</label>
      <select name="category_id" class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
        <option value="">— بدون فئة —</option>
        @foreach ($categories as $cat)
          <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="text-sm text-muted block mb-1">المخزون</label>
      <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 100) }}"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">الوصف</label>
    <textarea name="description" rows="3"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ old('description', $product->description) }}</textarea>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="text-sm text-muted block mb-1">السعر (ر.س)</label>
      <input type="number" name="price" value="{{ old('price', $product->price) }}" required
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <div>
      <label class="text-sm text-muted block mb-1">السعر قبل الخصم (اختياري)</label>
      <input type="number" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">صورة المنتج</label>
    @if ($product->image)
      <img src="{{ $product->image }}" class="w-24 h-24 object-cover rounded-lg mb-2 border border-line">
    @endif
    <input type="file" name="image" accept="image/*" class="text-sm text-muted">
  </div>

  <div class="flex items-center gap-6 text-sm">
    <label class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $product->is_published ?? true) ? 'checked' : '' }}> منشور</label>
    <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}> مميز</label>
    <label class="flex items-center gap-2"><input type="checkbox" name="is_on_offer" value="1" {{ old('is_on_offer', $product->is_on_offer) ? 'checked' : '' }}> ضمن العروض</label>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">ترتيب الظهور</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">
    {{ $product->exists ? 'حفظ التعديلات' : 'إضافة المنتج' }}
  </button>
</form>
@endsection
