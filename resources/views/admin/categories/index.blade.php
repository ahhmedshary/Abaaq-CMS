@extends('admin.layouts.app')
@section('title', 'الفئات')

@section('content')
<a href="{{ route('admin.categories.create') }}" class="inline-block bg-accent text-bg font-medium rounded-lg px-5 py-2 mb-6 hover:opacity-90 transition">+ فئة جديدة</a>

<div class="border border-line rounded-xl divide-y divide-line">
  @forelse ($categories as $category)
    <div class="flex items-center justify-between p-4">
      <span class="font-medium">{{ $category->name }}</span>
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.categories.edit', $category) }}" class="text-sm text-muted hover:text-accent">تعديل</a>
        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('حذف هذه الفئة؟')">
          @csrf @method('DELETE')
          <button class="text-sm text-muted hover:text-red-400">حذف</button>
        </form>
      </div>
    </div>
  @empty
    <p class="p-6 text-muted text-sm">لا توجد فئات بعد.</p>
  @endforelse
</div>
@endsection
