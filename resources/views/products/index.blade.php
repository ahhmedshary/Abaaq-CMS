@extends('layouts.app')
@section('title', 'المنتجات — عبق الشرق')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
  <h1 class="text-2xl font-extrabold mb-8">جميع المنتجات</h1>

  <div class="flex flex-wrap gap-2 mb-10">
    <a href="{{ route('products.index') }}"
       class="px-4 py-1.5 rounded-full text-sm {{ ! $activeCategory ? 'bg-maroon text-cream' : 'bg-sand text-ink' }}">
      الكل
    </a>
    @foreach ($categories as $category)
      <a href="{{ route('products.index', ['category' => $category->slug]) }}"
         class="px-4 py-1.5 rounded-full text-sm {{ $activeCategory === $category->slug ? 'bg-maroon text-cream' : 'bg-sand text-ink' }}">
        {{ $category->name }}
      </a>
    @endforeach
  </div>

  @if ($products->count())
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach ($products as $product)
        <x-product-card :product="$product" />
      @endforeach
    </div>

    <div class="mt-12">{{ $products->links() }}</div>
  @else
    <p class="text-muted text-center py-20">لا توجد منتجات في هذه الفئة حاليًا.</p>
  @endif
</div>
@endsection
