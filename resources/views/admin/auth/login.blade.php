<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>تسجيل الدخول · لوحة التحكم</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = { theme: { extend: { colors: {
    bg: '#14130f', soft: '#1c1b15', fg: '#f3eee3', muted: '#a8a190',
    accent: '#c9a05c', line: '#2c2a22'
  }}}}
</script>
</head>
<body class="bg-bg text-fg min-h-screen flex items-center justify-center">

<div class="w-full max-w-sm border border-line rounded-2xl p-8">
  <h1 class="text-xl font-semibold mb-1">لوحة تحكم المتجر</h1>
  <p class="text-muted text-sm mb-8">سجل دخولك لإدارة المنتجات والطلبات.</p>

  @if ($errors->any())
    <div class="mb-6 bg-red-500/10 border border-red-500 text-red-400 text-sm rounded-lg px-4 py-3">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
    @csrf
    <div>
      <label class="text-sm text-muted block mb-1">البريد الإلكتروني</label>
      <input type="email" name="email" value="{{ old('email') }}" required autofocus
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <div>
      <label class="text-sm text-muted block mb-1">كلمة المرور</label>
      <input type="password" name="password" required
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <button type="submit" class="w-full bg-accent text-bg font-medium rounded-lg py-2.5 hover:opacity-90 transition">
      تسجيل الدخول
    </button>
  </form>
</div>

</body>
</html>
