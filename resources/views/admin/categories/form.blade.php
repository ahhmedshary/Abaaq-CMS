@extends('admin.layouts.app')
@section('title', $category->exists ? 'تعديل فئة' : 'فئة جديدة')

@section('content')
<form method="POST"
  action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
  enctype="multipart/form-data" class="space-y-5">
  @csrf
  @if ($category->exists) @method('PUT') @endif

  <div>
    <label class="text-sm text-muted block mb-1">اسم الفئة</label>
    <input name="name" value="{{ old('name', $category->name) }}" required
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">صورة الفئة</label>
    @if ($category->image)
      <img src="{{ $category->image }}" class="w-20 h-20 object-cover rounded-full mb-2 border border-line">
    @endif
    <input type="file" name="image" accept="image/*" class="text-sm text-muted">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">ترتيب الظهور</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">
    {{ $category->exists ? 'حفظ التعديلات' : 'إضافة الفئة' }}
  </button>
</form>
@endsection
