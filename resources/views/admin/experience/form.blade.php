@extends('admin.layouts.app')
@section('title', $row->exists ? 'Edit experience' : 'New experience')

@section('content')
<form method="POST"
  action="{{ $row->exists ? route('admin.experience.update', $row) : route('admin.experience.store') }}"
  class="space-y-5">
  @csrf
  @if ($row->exists) @method('PUT') @endif

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="text-sm text-muted block mb-1">Period</label>
      <input name="period" value="{{ old('period', $row->period) }}" required placeholder="2023 — Now"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <div>
      <label class="text-sm text-muted block mb-1">Role</label>
      <input name="role" value="{{ old('role', $row->role) }}" required
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Organization</label>
    <input name="org" value="{{ old('org', $row->org) }}" required
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Description</label>
    <textarea name="description" rows="3"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ old('description', $row->description) }}</textarea>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Sort order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $row->sort_order ?? 0) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">
    {{ $row->exists ? 'Save changes' : 'Create entry' }}
  </button>
</form>
@endsection
