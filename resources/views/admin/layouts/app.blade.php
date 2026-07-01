<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'لوحة التحكم')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
  tailwind.config = { theme: { extend: { colors: {
    bg: '#14130f', soft: '#1c1b15', fg: '#f3eee3', muted: '#a8a190',
    accent: '#c9a05c', line: '#2c2a22'
  }}}}
</script>
</head>
<body class="bg-bg text-fg min-h-screen">

<div class="flex">
  <aside class="w-64 border-l border-line min-h-screen p-6 hidden md:block">
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold mb-10 block">عبق الشرق <span class="text-accent">CMS</span></a>
    <nav class="space-y-1 text-sm">
      <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-soft {{ request()->routeIs('admin.dashboard') ? 'bg-soft text-accent' : 'text-muted' }}">لوحة التحكم</a>
      <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 rounded-lg hover:bg-soft {{ request()->routeIs('admin.products.*') ? 'bg-soft text-accent' : 'text-muted' }}">المنتجات</a>
      <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-lg hover:bg-soft {{ request()->routeIs('admin.categories.*') ? 'bg-soft text-accent' : 'text-muted' }}">الفئات</a>
      <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded-lg hover:bg-soft {{ request()->routeIs('admin.orders.*') ? 'bg-soft text-accent' : 'text-muted' }}">الطلبات</a>
      <a href="{{ route('admin.page-builder.index') }}" class="block px-3 py-2 rounded-lg hover:bg-soft {{ request()->routeIs('admin.page-builder.*') ? 'bg-soft text-accent' : 'text-muted' }}">🧱 Page Builder</a>
      <a href="{{ route('admin.settings.edit') }}" class="block px-3 py-2 rounded-lg hover:bg-soft {{ request()->routeIs('admin.settings.*') ? 'bg-soft text-accent' : 'text-muted' }}">إعدادات الصفحة الرئيسية</a>
    </nav>
    <form method="POST" action="{{ route('admin.logout') }}" class="mt-10">
      @csrf
      <button class="text-sm text-muted hover:text-accent">تسجيل الخروج</button>
    </form>
  </aside>

  <main class="flex-1 p-6 md:p-10 max-w-5xl">
    <h1 class="text-2xl font-semibold mb-8">@yield('title')</h1>

    @if (session('status'))
      <div class="mb-6 bg-accent/10 border border-accent text-accent text-sm rounded-lg px-4 py-3">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
      <div class="mb-6 bg-red-500/10 border border-red-500 text-red-400 text-sm rounded-lg px-4 py-3">
        <ul class="list-disc pr-4 space-y-1">
          @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>
</div>

</body>
</html>
