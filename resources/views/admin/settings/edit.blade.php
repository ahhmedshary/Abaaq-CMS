@extends('admin.layouts.app')
@section('title', 'إعدادات الصفحة الرئيسية')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5">
  @csrf @method('PUT')

  <div>
    <label class="text-sm text-muted block mb-1">عنوان البانر الرئيسي</label>
    <input name="hero_title" value="{{ old('hero_title', $values['hero_title']) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">نص البانر الرئيسي</label>
    <textarea name="hero_subtitle" rows="2"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ old('hero_subtitle', $values['hero_subtitle']) }}</textarea>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">نص "من نحن"</label>
    <textarea name="about_text" rows="3"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ old('about_text', $values['about_text']) }}</textarea>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">عنوان البانر الترويجي</label>
    <input name="banner_title" value="{{ old('banner_title', $values['banner_title']) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">نص البانر الترويجي</label>
    <input name="banner_subtitle" value="{{ old('banner_subtitle', $values['banner_subtitle']) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">عنوان قسم العرض المحدود</label>
    <input name="offer_title" value="{{ old('offer_title', $values['offer_title']) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">تاريخ ووقت انتهاء العرض</label>
    <input type="datetime-local" name="offer_ends_at" value="{{ \Illuminate\Support\Carbon::parse(old('offer_ends_at', $values['offer_ends_at']))->format('Y-m-d\TH:i') }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">حساب انستقرام</label>
    <input name="instagram_handle" value="{{ old('instagram_handle', $values['instagram_handle']) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">حفظ الإعدادات</button>
</form>
@endsection
