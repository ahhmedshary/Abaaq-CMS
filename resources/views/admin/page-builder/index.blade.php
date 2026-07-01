@extends('admin.layouts.app')
@section('title', 'Page Builder — الصفحة الرئيسية')

@section('content')

<p class="text-muted text-sm mb-6">اسحب الأقسام لتغيير ترتيبها. اضغط على زر العين لإظهار/إخفاء القسم.</p>

<div id="sections-list" class="flex flex-col gap-3">
  @foreach ($sections as $section)
    <div
      class="section-row flex items-center gap-4 border border-line rounded-xl p-4 bg-soft/30 cursor-grab active:cursor-grabbing transition"
      data-id="{{ $section->id }}"
    >
      {{-- drag handle --}}
      <div class="text-muted select-none text-lg shrink-0" title="اسحب للترتيب">⠿</div>

      {{-- section icon --}}
      <div class="w-10 h-10 rounded-lg bg-soft border border-line flex items-center justify-center text-lg shrink-0">
        @switch($section->type)
          @case('hero')        🖼️ @break
          @case('categories')  🗂️ @break
          @case('featured')    ⭐ @break
          @case('latest')      🕐 @break
          @case('on_offer')    🏷️ @break
          @case('banner')      📢 @break
          @case('countdown')   ⏳ @break
          @case('instagram')   📸 @break
          @default             📄
        @endswitch
      </div>

      {{-- label --}}
      <div class="flex-1 min-w-0">
        <p class="font-medium text-sm">{{ $section->label }}</p>
        <p class="text-xs text-muted mt-0.5">{{ $section->type }}</p>
      </div>

      {{-- sort order badge --}}
      <span class="sort-badge text-xs text-muted border border-line rounded px-2 py-1 w-8 text-center">
        {{ $section->sort_order }}
      </span>

      {{-- visible toggle --}}
      <button
        class="toggle-btn flex items-center justify-center w-9 h-9 rounded-lg border border-line hover:border-accent transition"
        data-id="{{ $section->id }}"
        data-visible="{{ $section->is_visible ? '1' : '0' }}"
        title="{{ $section->is_visible ? 'إخفاء القسم' : 'إظهار القسم' }}"
      >
        @if ($section->is_visible)
          <span class="eye-icon text-accent">👁️</span>
        @else
          <span class="eye-icon text-muted opacity-40">🚫</span>
        @endif
      </button>

      {{-- edit settings --}}
      <a href="{{ route('admin.page-builder.edit', $section) }}"
        class="flex items-center gap-1 text-xs text-muted hover:text-accent border border-line hover:border-accent rounded-lg px-3 py-2 transition">
        ✏️ تعديل
      </a>
    </div>
  @endforeach
</div>

<div id="save-order-bar" class="hidden mt-6 flex items-center justify-between bg-accent/10 border border-accent rounded-xl px-5 py-3">
  <span class="text-sm text-accent">رتّبت الأقسام — احفظ لتطبيق الترتيب الجديد على الموقع</span>
  <button id="save-order-btn" class="bg-accent text-bg text-sm font-medium rounded-lg px-5 py-2 hover:opacity-90 transition">
    💾 حفظ الترتيب
  </button>
</div>

{{-- SortableJS CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const list   = document.getElementById('sections-list');
const bar    = document.getElementById('save-order-bar');
const saveBtn= document.getElementById('save-order-btn');
let dirty    = false;

// Drag & drop reorder
Sortable.create(list, {
  animation: 200,
  handle: '[title="اسحب للترتيب"]',
  ghostClass: 'opacity-30',
  onEnd() {
    dirty = true;
    bar.classList.remove('hidden');
    // Update sort badges visually
    document.querySelectorAll('.section-row').forEach((row, i) => {
      row.querySelector('.sort-badge').textContent = i + 1;
    });
  }
});

// Save new order
saveBtn.addEventListener('click', async () => {
  saveBtn.textContent = 'جاري الحفظ...';
  const rows = document.querySelectorAll('.section-row');
  const payload = Array.from(rows).map((row, i) => ({
    id: +row.dataset.id,
    order: i + 1,
  }));

  const res = await fetch("{{ route('admin.page-builder.reorder') }}", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ sections: payload }),
  });

  if (res.ok) {
    dirty = false;
    bar.classList.add('hidden');
    saveBtn.textContent = '💾 حفظ الترتيب';
  }
});

// Toggle visibility
document.querySelectorAll('.toggle-btn').forEach(btn => {
  btn.addEventListener('click', async () => {
    const id  = btn.dataset.id;
    const res = await fetch(`/admin/page-builder/${id}/toggle`, {
      method: 'PATCH',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
    });
    const data = await res.json();
    btn.dataset.visible = data.is_visible ? '1' : '0';
    btn.querySelector('.eye-icon').textContent = data.is_visible ? '👁️' : '🚫';
    btn.querySelector('.eye-icon').className = data.is_visible
      ? 'eye-icon text-accent'
      : 'eye-icon text-muted opacity-40';
  });
});
</script>

@endsection
