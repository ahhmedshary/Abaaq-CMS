@extends('admin.layouts.app')
@section('title', 'Testimonials')

@section('content')
<a href="{{ route('admin.testimonials.create') }}" class="inline-block bg-accent text-bg font-medium rounded-lg px-5 py-2 mb-6 hover:opacity-90 transition">
  + New testimonial
</a>

<div class="border border-line rounded-xl divide-y divide-line">
  @forelse ($testimonials as $t)
    <div class="flex items-center justify-between p-4">
      <div class="max-w-xl">
        <div class="font-medium">{{ $t->name }} <span class="text-muted font-normal">· {{ $t->role }}</span></div>
        <div class="text-sm text-muted mt-1 line-clamp-1">{{ $t->quote }}</div>
      </div>
      <div class="flex items-center gap-3 shrink-0">
        <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-sm text-muted hover:text-accent">Edit</a>
        <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('Delete this testimonial?')">
          @csrf @method('DELETE')
          <button class="text-sm text-muted hover:text-red-400">Delete</button>
        </form>
      </div>
    </div>
  @empty
    <p class="p-6 text-muted text-sm">No testimonials yet.</p>
  @endforelse
</div>
@endsection
