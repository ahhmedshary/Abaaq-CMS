@extends('admin.layouts.app')
@section('title', $skill->exists ? 'Edit skill group' : 'New skill group')

@section('content')
<form method="POST"
  action="{{ $skill->exists ? route('admin.skills.update', $skill) : route('admin.skills.store') }}"
  class="space-y-5">
  @csrf
  @if ($skill->exists) @method('PUT') @endif

  <div>
    <label class="text-sm text-muted block mb-1">Group name</label>
    <input name="group_name" value="{{ old('group_name', $skill->group_name) }}" required placeholder="e.g. Design"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Skills (comma separated)</label>
    <textarea name="items" rows="3" required placeholder="Product Strategy, Prototyping, Design Systems"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ old('items', $skill->items ? implode(', ', $skill->items) : '') }}</textarea>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Sort order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $skill->sort_order ?? 0) }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">
    {{ $skill->exists ? 'Save changes' : 'Create group' }}
  </button>
</form>
@endsection
