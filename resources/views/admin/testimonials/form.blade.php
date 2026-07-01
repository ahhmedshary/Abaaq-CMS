@extends('admin.layouts.app')
@section('title', $testimonial->exists ? 'Edit testimonial' : 'New testimonial')

@section('content')
<form method="POST"
  action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
  class="space-y-5">
  @csrf
  @if ($testimonial->exists) @method('PUT') @endif

  <div>
    <label class="text-sm text-muted block mb-1">Quote</label>
    <textarea name="quote" rows="3" required
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ old('quote', $testimonial->quote) }}</textarea>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="text-sm text-muted block mb-1">Name</label>
      <input name="name" value="{{ old('name', $testimonial->name) }}" required
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <div>
      <label class="text-sm text-muted block mb-1">Role / company</label>
      <input name="role" value="{{ old('role', $testimonial->role) }}"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Sort order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">
    {{ $testimonial->exists ? 'Save changes' : 'Create testimonial' }}
  </button>
</form>
@endsection
