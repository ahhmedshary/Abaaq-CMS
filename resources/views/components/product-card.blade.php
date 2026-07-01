@props(['product'])

<div class="group">
  <a href="{{ route('products.show', $product->slug) }}" class="block aspect-square rounded-xl overflow-hidden bg-sand relative">
    @if ($product->image)
      <img src="{{ $product->image }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
    @else
      <div class="w-full h-full flex items-center justify-center text-muted text-xs">لا توجد صورة</div>
    @endif

    @if ($product->discount_percent)
      <span class="absolute top-2 right-2 bg-maroon text-cream text-[11px] px-2 py-1 rounded-full">خصم {{ $product->discount_percent }}%</span>
    @endif
  </a>

  <a href="{{ route('products.show', $product->slug) }}" class="block mt-3 text-sm font-medium hover:text-maroon">
    {{ $product->name }}
  </a>

  <div class="flex items-center gap-2 mt-1">
    <span class="text-maroon font-bold text-sm">{{ $product->price_formatted }}</span>
    @if ($product->compare_price_formatted)
      <span class="text-muted text-xs line-through">{{ $product->compare_price_formatted }}</span>
    @endif
  </div>

  <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-2">
    @csrf
    <button class="w-full flex items-center justify-center gap-2 bg-maroon text-cream text-xs font-medium rounded-lg py-2 hover:bg-maroon2 transition">
      أضف الى السلة
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    </button>
  </form>
</div>
