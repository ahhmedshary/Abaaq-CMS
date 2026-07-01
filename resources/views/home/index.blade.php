@extends('layouts.app')
@section('title', 'الرئيسية — عبق الشرق')

@section('content')

{{-- HERO --}}
<section class="relative bg-gradient-to-l from-sand to-cream overflow-hidden">
  <div class="max-w-7xl mx-auto px-4 py-16 md:py-24 grid md:grid-cols-2 items-center gap-10">
    <div class="order-2 md:order-1 text-center md:text-right">
      <h1 class="text-3xl md:text-5xl font-extrabold text-maroon leading-tight">{{ $settings['hero_title'] }}</h1>
      <p class="text-muted mt-5 leading-relaxed max-w-md mx-auto md:mx-0 md:mr-0">{{ $settings['hero_subtitle'] }}</p>
      <a href="{{ route('products.index') }}" class="inline-block mt-7 bg-maroon text-cream font-bold rounded-lg px-8 py-3 hover:bg-maroon2 transition">تسوق الآن</a>
    </div>
    <div class="order-1 md:order-2 flex justify-center">
      <div class="w-64 h-80 md:w-80 md:h-96 rounded-2xl bg-gradient-to-b from-maroon2 to-maroon shadow-2xl flex items-center justify-center">
        <span class="text-cream/30 text-sm">صورة المنتج الرئيسية</span>
      </div>
    </div>
  </div>
</section>

{{-- ABOUT --}}
<section class="max-w-3xl mx-auto px-4 py-16 text-center">
  <p class="text-ink leading-loose">{{ $settings['about_text'] }}</p>
  <a href="#" class="inline-block mt-4 text-maroon font-bold text-sm">اعرف المزيد</a>
  <div class="mt-8 w-16 h-16 mx-auto rounded-full border-2 border-gold flex items-center justify-center">
    <div class="w-10 h-10 rounded-full bg-maroon"></div>
  </div>
</section>

{{-- PROMO BANNER --}}
<section class="max-w-7xl mx-auto px-4">
  <div class="relative rounded-2xl overflow-hidden bg-gradient-to-l from-ink to-maroon h-72 md:h-80 flex items-center px-8 md:px-14">
    <div class="text-cream max-w-md">
      <h2 class="text-2xl md:text-3xl font-extrabold">{{ $settings['banner_title'] }}</h2>
      <p class="text-cream/70 mt-3">{{ $settings['banner_subtitle'] }}</p>
      <a href="{{ route('products.index') }}" class="inline-block mt-6 bg-gold text-ink font-bold rounded-lg px-7 py-2.5 hover:opacity-90 transition">تسوق الآن</a>
    </div>
  </div>
</section>

{{-- DAILY PICKS --}}
@if ($latest->count())
<section class="max-w-7xl mx-auto px-4 py-16">
  <h2 class="text-2xl font-extrabold text-center mb-10">كل اللي يعبّر عن عطرك اليومي</h2>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5">
    @foreach ($latest as $product)
      <x-product-card :product="$product" />
    @endforeach
  </div>
</section>
@endif

{{-- CATEGORIES --}}
@if ($categories->count())
<section class="max-w-7xl mx-auto px-4 pb-16">
  <h2 class="text-2xl font-extrabold text-center mb-10">تسوق حسب الفئة</h2>
  <div class="flex flex-wrap justify-center gap-8 md:gap-14">
    @foreach ($categories as $category)
      <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-center group">
        <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-sand mx-auto flex items-center justify-center overflow-hidden border-2 border-transparent group-hover:border-gold transition">
          @if ($category->image)
            <img src="{{ $category->image }}" class="w-full h-full object-cover">
          @else
            <span class="text-xs text-muted">{{ $category->name }}</span>
          @endif
        </div>
        <p class="mt-2 text-sm font-medium">{{ $category->name }}</p>
      </a>
    @endforeach
  </div>
</section>
@endif

{{-- FEATURED --}}
@if ($featured->count())
<section class="max-w-7xl mx-auto px-4 pb-16">
  <div class="flex items-center justify-between mb-10">
    <a href="{{ route('products.index') }}" class="text-sm text-maroon font-medium">عرض كل المنتجات</a>
    <h2 class="text-2xl font-extrabold">منتجات مختارة بعناية</h2>
  </div>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5">
    @foreach ($featured as $product)
      <x-product-card :product="$product" />
    @endforeach
  </div>
</section>
@endif

{{-- COUNTDOWN OFFER --}}
<section class="max-w-7xl mx-auto px-4 pb-16">
  <div class="bg-gradient-to-l from-maroon to-maroon2 rounded-2xl px-8 py-10 md:py-14 text-cream text-center" x-data>
    <h2 class="text-xl md:text-2xl font-extrabold max-w-xl mx-auto leading-relaxed">{{ $settings['offer_title'] }}</h2>
    <div id="countdown" class="flex items-center justify-center gap-3 mt-6" data-end="{{ $settings['offer_ends_at'] }}">
      <div class="bg-cream/10 rounded-lg px-4 py-2 text-lg font-bold w-16" id="cd-days">00</div>
      <span>:</span>
      <div class="bg-cream/10 rounded-lg px-4 py-2 text-lg font-bold w-16" id="cd-hours">00</div>
      <span>:</span>
      <div class="bg-cream/10 rounded-lg px-4 py-2 text-lg font-bold w-16" id="cd-minutes">00</div>
      <span>:</span>
      <div class="bg-cream/10 rounded-lg px-4 py-2 text-lg font-bold w-16" id="cd-seconds">00</div>
    </div>
    <a href="{{ route('products.index') }}" class="inline-block mt-7 bg-gold text-ink font-bold rounded-lg px-8 py-3 hover:opacity-90 transition">تسوق الآن</a>
  </div>
</section>

<script>
  (function () {
    const el = document.getElementById('countdown');
    if (!el) return;
    const end = new Date(el.dataset.end).getTime();

    function tick() {
      const diff = Math.max(0, end - Date.now());
      const d = Math.floor(diff / 86400000);
      const h = Math.floor((diff % 86400000) / 3600000);
      const m = Math.floor((diff % 3600000) / 60000);
      const s = Math.floor((diff % 60000) / 1000);
      document.getElementById('cd-days').textContent = String(d).padStart(2, '0');
      document.getElementById('cd-hours').textContent = String(h).padStart(2, '0');
      document.getElementById('cd-minutes').textContent = String(m).padStart(2, '0');
      document.getElementById('cd-seconds').textContent = String(s).padStart(2, '0');
    }
    tick();
    setInterval(tick, 1000);
  })();
</script>

{{-- ON OFFER --}}
@if ($onOffer->count())
<section class="max-w-7xl mx-auto px-4 pb-20">
  <h2 class="text-2xl font-extrabold text-center mb-10">منتجات العروض</h2>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5">
    @foreach ($onOffer as $product)
      <x-product-card :product="$product" />
    @endforeach
  </div>
</section>
@endif

{{-- INSTAGRAM --}}
<section class="max-w-7xl mx-auto px-4 pb-20 text-center">
  <h2 class="text-2xl font-extrabold mb-2">تابعونا على إنستقرام</h2>
  <p class="text-muted text-sm mb-8">{{ $settings['instagram_handle'] }}</p>
  <div class="grid grid-cols-3 md:grid-cols-5 gap-3">
    @for ($i = 0; $i < 5; $i++)
      <div class="aspect-square rounded-xl bg-sand"></div>
    @endfor
  </div>
</section>

@endsection
