@extends('admin.layouts.app')
@section('title', $project->exists ? 'Edit project' : 'New project')

@section('content')
<form method="POST"
  action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
  enctype="multipart/form-data" class="space-y-5">
  @csrf
  @if ($project->exists) @method('PUT') @endif

  <div>
    <label class="text-sm text-muted block mb-1">Title</label>
    <input name="title" value="{{ old('title', $project->title) }}" required
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="text-sm text-muted block mb-1">Category</label>
      <input name="category" value="{{ old('category', $project->category) }}"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <div>
      <label class="text-sm text-muted block mb-1">Year</label>
      <input name="year" value="{{ old('year', $project->year) }}"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Description</label>
    <textarea name="description" rows="3"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ old('description', $project->description) }}</textarea>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Tags (comma separated)</label>
    <input name="tags" value="{{ old('tags', $project->tags ? implode(', ', $project->tags) : '') }}"
      placeholder="Product Design, React, Branding"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">External link</label>
    <input name="link" value="{{ old('link', $project->link) }}" placeholder="https://..."
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Cover image</label>
    @if ($project->image)
      <img src="{{ $project->image }}" class="w-32 aspect-[4/3] object-cover rounded-lg mb-2 border border-line">
    @endif
    <input type="file" name="image" accept="image/*" class="text-sm text-muted">
  </div>

  <div class="grid grid-cols-2 gap-4 items-end">
    <div>
      <label class="text-sm text-muted block mb-1">Sort order</label>
      <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <label class="flex items-center gap-2 text-sm text-muted pb-2">
      <input type="checkbox" name="is_published" value="1" {{ old('is_published', $project->is_published ?? true) ? 'checked' : '' }}>
      Published (visible on site)
    </label>
  </div>

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">
    {{ $project->exists ? 'Save changes' : 'Create project' }}
  </button>
</form>
@endsection
