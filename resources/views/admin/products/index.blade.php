@extends('admin.layouts.app')
@section('title', 'المنتجات')

@section('content')
<a href="{{ route('admin.products.create') }}" class="inline-block bg-accent text-bg font-medium rounded-lg px-5 py-2 mb-6 hover:opacity-90 transition">+ منتج جديد</a>

<div class="border border-line rounded-xl divide-y divide-line">
  @forelse ($products as $product)
    <div class="flex items-center justify-between p-4">
      <div class="flex items-center gap-4">
        @if ($product->image)
          <img src="{{ $product->image }}" class="w-14 h-14 rounded-lg object-cover border border-line">
        @else
          <div class="w-14 h-14 rounded-lg bg-soft border border-line"></div>
        @endif
        <div>
          <div class="font-medium">{{ $product->name }}</div>
          <div class="text-sm text-muted">{{ $product->category?->name }} · {{ number_format($product->price) }} ر.س</div>
        </div>
      </div>
      <div class="flex items-center gap-3">
        @unless ($product->is_published)
          <span class="text-xs text-muted">مخفي</span>
        @endunless
        <a href="{{ route('admin.products.edit', $product) }}" class="text-sm text-muted hover:text-accent">تعديل</a>
        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('حذف هذا المنتج؟')">
          @csrf @method('DELETE')
          <button class="text-sm text-muted hover:text-red-400">حذف</button>
        </form>
      </div>
    </div>
  @empty
    <p class="p-6 text-muted text-sm">لا توجد منتجات بعد.</p>
  @endforelse
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
