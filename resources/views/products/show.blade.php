@extends('layouts.app')
@section('title', $product->name . ' — عبق الشرق')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
  <div class="grid md:grid-cols-2 gap-12">
    <div class="aspect-square rounded-2xl bg-sand overflow-hidden">
      @if ($product->image)
        <img src="{{ $product->image }}" class="w-full h-full object-cover">
      @endif
    </div>

    <div>
      @if ($product->category)
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-sm text-maroon">{{ $product->category->name }}</a>
      @endif

      <h1 class="text-3xl font-extrabold mt-2">{{ $product->name }}</h1>

      <div class="flex items-center gap-3 mt-4">
        <span class="text-2xl font-bold text-maroon">{{ $product->price_formatted }}</span>
        @if ($product->compare_price_formatted)
          <span class="text-muted line-through">{{ $product->compare_price_formatted }}</span>
          <span class="bg-maroon/10 text-maroon text-xs px-2 py-1 rounded-full">خصم {{ $product->discount_percent }}%</span>
        @endif
      </div>

      <p class="text-muted leading-loose mt-6">{{ $product->description }}</p>

      <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-8 flex items-center gap-4">
        @csrf
        <input type="number" name="quantity" value="1" min="1" class="w-20 bg-sand rounded-lg px-3 py-2.5 text-center focus:outline-none">
        <button class="flex-1 bg-maroon text-cream font-bold rounded-lg py-2.5 hover:bg-maroon2 transition">
          أضف الى السلة
        </button>
      </form>

      @if ($product->stock > 0)
        <p class="text-sm text-green-700 mt-3">متوفر في المخزون</p>
      @else
        <p class="text-sm text-red-600 mt-3">غير متوفر حاليًا</p>
      @endif
    </div>
  </div>

  @if ($related->count())
    <div class="mt-20">
      <h2 class="text-xl font-extrabold mb-8">منتجات ذات صلة</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($related as $item)
          <x-product-card :product="$item" />
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection
