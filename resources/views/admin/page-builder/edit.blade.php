@extends('admin.layouts.app')
@section('title', 'تعديل: ' . $section->label)

@section('content')

<a href="{{ route('admin.page-builder.index') }}" class="text-sm text-muted hover:text-accent mb-6 inline-block">← رجوع للـ Page Builder</a>

<form method="POST" action="{{ route('admin.page-builder.update', $section) }}" enctype="multipart/form-data" class="space-y-5">
  @csrf @method('PUT')

  @php $s = $section->settings ?? []; @endphp

  {{-- ============================================================ --}}
  {{-- HERO --}}
  {{-- ============================================================ --}}
  @if ($section->type === 'hero')
    <x-pb-field label="عنوان البانر" name="title" :value="$s['title'] ?? ''" />
    <x-pb-field label="النص التحت العنوان" name="subtitle" :value="$s['subtitle'] ?? ''" type="textarea" />
    <x-pb-field label="نص الزر" name="cta_text" :value="$s['cta_text'] ?? 'تسوق الآن'" />
    <x-pb-field label="رابط الزر" name="cta_url" :value="$s['cta_url'] ?? '/products'" />
    <x-pb-image label="صورة الخلفية" name="image" :current="$s['image'] ?? ''" />
  @endif

  {{-- ============================================================ --}}
  {{-- CATEGORIES --}}
  {{-- ============================================================ --}}
  @if ($section->type === 'categories')
    <x-pb-field label="عنوان القسم" name="title" :value="$s['title'] ?? 'تسوق حسب الفئة'" />
    <p class="text-sm text-muted">الفئات تُجلب تلقائيًا من قسم <a href="{{ route('admin.categories.index') }}" class="text-accent">إدارة الفئات</a>.</p>
  @endif

  {{-- ============================================================ --}}
  {{-- LATEST / FEATURED / ON_OFFER --}}
  {{-- ============================================================ --}}
  @if (in_array($section->type, ['latest', 'featured', 'on_offer']))
    <x-pb-field label="عنوان القسم" name="title" :value="$s['title'] ?? ''" />
    <div>
      <label class="text-sm text-muted block mb-1">عدد المنتجات المعروضة</label>
      <select name="limit" class="bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
        @foreach ([3, 4, 6, 8, 12] as $n)
          <option value="{{ $n }}" {{ ($s['limit'] ?? 6) == $n ? 'selected' : '' }}>{{ $n }}</option>
        @endforeach
      </select>
    </div>
  @endif

  {{-- ============================================================ --}}
  {{-- BANNER --}}
  {{-- ============================================================ --}}
  @if ($section->type === 'banner')
    <x-pb-field label="العنوان" name="title" :value="$s['title'] ?? ''" />
    <x-pb-field label="النص الفرعي" name="subtitle" :value="$s['subtitle'] ?? ''" type="textarea" />
    <x-pb-field label="نص الزر" name="cta_text" :value="$s['cta_text'] ?? 'تسوق الآن'" />
    <x-pb-field label="رابط الزر" name="cta_url" :value="$s['cta_url'] ?? '/products'" />
    <x-pb-image label="صورة الخلفية" name="image" :current="$s['image'] ?? ''" />
  @endif

  {{-- ============================================================ --}}
  {{-- COUNTDOWN --}}
  {{-- ============================================================ --}}
  @if ($section->type === 'countdown')
    <x-pb-field label="عنوان العرض" name="title" :value="$s['title'] ?? ''" type="textarea" />
    <div>
      <label class="text-sm text-muted block mb-1">تاريخ ووقت انتهاء العرض</label>
      <input type="datetime-local" name="ends_at"
        value="{{ $s['ends_at'] ? \Carbon\Carbon::parse($s['ends_at'])->format('Y-m-d\TH:i') : '' }}"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <x-pb-field label="نص الزر" name="cta_text" :value="$s['cta_text'] ?? 'تسوق الآن'" />
    <x-pb-field label="رابط الزر" name="cta_url" :value="$s['cta_url'] ?? '/products'" />
  @endif

  {{-- ============================================================ --}}
  {{-- INSTAGRAM --}}
  {{-- ============================================================ --}}
  @if ($section->type === 'instagram')
    <x-pb-field label="عنوان القسم" name="title" :value="$s['title'] ?? 'تابعونا على إنستقرام'" />
    <x-pb-field label="حساب إنستقرام" name="handle" :value="$s['handle'] ?? '@YourStore'" />
    <div>
      <label class="text-sm text-muted block mb-1">عدد الصور</label>
      <select name="count" class="bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
        @foreach ([3, 4, 5, 6] as $n)
          <option value="{{ $n }}" {{ ($s['count'] ?? 5) == $n ? 'selected' : '' }}>{{ $n }}</option>
        @endforeach
      </select>
    </div>
  @endif

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">
    💾 حفظ التغييرات
  </button>
</form>

@endsection
