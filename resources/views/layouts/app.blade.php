<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'عبق الشرق — بخور وعود فاخر')</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: { colors: {
    maroon: '#4a1626', maroon2: '#5e1f33', cream: '#faf6f0', sand: '#f0e6d8',
    gold: '#c9a05c', ink: '#2b2018', muted: '#8a7d6e'
  }, fontFamily: { arabic: ['Tajawal', 'sans-serif'] } } } }
</script>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
<style> body { font-family: 'Tajawal', sans-serif; } </style>
</head>
<body class="bg-cream text-ink">

{{-- top bar --}}
<div class="bg-maroon text-cream text-xs py-2 px-4 flex items-center justify-between">
  <div class="flex items-center gap-4">
    <span>عروض جديدة ومخفضات تصل الى 40%</span>
  </div>
  <div class="hidden md:flex items-center gap-1">
    <span>5 أيام : 6 ساعات : 22 دقيقة : 0 ثواني</span>
  </div>
</div>

{{-- header --}}
<header class="bg-cream border-b border-sand">
  <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
    <a href="{{ route('home') }}" class="text-xl font-extrabold text-maroon">عبق الشرق</a>

    <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
      <a href="{{ route('home') }}" class="hover:text-maroon">الرئيسية</a>
      <a href="{{ route('products.index') }}" class="hover:text-maroon">العروض</a>
      <a href="{{ route('products.index') }}" class="hover:text-maroon">المنتجات</a>
      <a href="#" class="hover:text-maroon">من نحن</a>
      <a href="#" class="hover:text-maroon">المدونة</a>
      <a href="#" class="hover:text-maroon">تواصل معنا</a>
    </nav>

    <div class="flex items-center gap-4">
      <form action="{{ route('products.index') }}" class="hidden md:block">
        <input name="q" placeholder="ابحث عن منتج..." class="bg-sand rounded-full px-4 py-1.5 text-sm focus:outline-none">
      </form>
      <a href="{{ route('cart.index') }}" class="relative">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 4.6A1 1 0 005.6 19H17M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/></svg>
        @if(($cartCount = app(\App\Services\CartService::class)->count()) > 0)
          <span class="absolute -top-2 -left-2 bg-maroon text-cream text-[10px] w-4 h-4 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
        @endif
      </a>
    </div>
  </div>
</header>

<main>
  @if (session('status'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
      <div class="bg-gold/20 border border-gold text-maroon text-sm rounded-lg px-4 py-3">{{ session('status') }}</div>
    </div>
  @endif

  @yield('content')
</main>

{{-- footer --}}
<footer class="bg-maroon text-cream mt-20">
  <div class="max-w-7xl mx-auto px-4 py-14 grid md:grid-cols-4 gap-10 text-sm">
    <div>
      <h3 class="font-bold mb-4">روابط سريعة</h3>
      <ul class="space-y-2 text-cream/70">
        <li><a href="{{ route('home') }}">الرئيسية</a></li>
        <li><a href="{{ route('products.index') }}">المنتجات</a></li>
        <li><a href="#">من نحن</a></li>
      </ul>
    </div>
    <div>
      <h3 class="font-bold mb-4">المساعدة</h3>
      <ul class="space-y-2 text-cream/70">
        <li><a href="#">الشروط والأحكام</a></li>
        <li><a href="#">سياسة الخصوصية</a></li>
        <li><a href="#">تتبع الطلب</a></li>
      </ul>
    </div>
    <div>
      <h3 class="font-bold mb-4">تواصل معنا</h3>
      <p class="text-cream/70">+966 275 2641</p>
      <p class="text-cream/70 mt-1">hello@store.com</p>
    </div>
    <div>
      <h3 class="font-bold mb-4">اشترك الآن لتصلك العروض الحصرية</h3>
      <form class="flex">
        <input placeholder="بريدك الإلكتروني" class="bg-cream/10 border border-cream/30 rounded-r-lg px-3 py-2 text-cream placeholder:text-cream/50 flex-1 text-xs focus:outline-none">
        <button class="bg-gold text-maroon px-4 rounded-l-lg text-xs font-bold">اشترك</button>
      </form>
    </div>
  </div>
  <div class="border-t border-cream/10 py-4 text-center text-xs text-cream/50">
    جميع الحقوق محفوظة © {{ date('Y') }}
  </div>
</footer>

</body>
</html>
