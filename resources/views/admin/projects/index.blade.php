@extends('admin.layouts.app')
@section('title', 'Projects')

@section('content')
<a href="{{ route('admin.projects.create') }}" class="inline-block bg-accent text-bg font-medium rounded-lg px-5 py-2 mb-6 hover:opacity-90 transition">
  + New project
</a>

<div class="border border-line rounded-xl divide-y divide-line">
  @forelse ($projects as $project)
    <div class="flex items-center justify-between p-4">
      <div class="flex items-center gap-4">
        @if ($project->image)
          <img src="{{ $project->image }}" class="w-14 h-14 rounded-lg object-cover border border-line">
        @else
          <div class="w-14 h-14 rounded-lg bg-soft border border-line"></div>
        @endif
        <div>
          <div class="font-medium">{{ $project->title }}</div>
          <div class="text-sm text-muted">{{ $project->category }} · {{ $project->year }}</div>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.projects.edit', $project) }}" class="text-sm text-muted hover:text-accent">Edit</a>
        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">
          @csrf @method('DELETE')
          <button class="text-sm text-muted hover:text-red-400">Delete</button>
        </form>
      </div>
    </div>
  @empty
    <p class="p-6 text-muted text-sm">No projects yet. Add your first one above.</p>
  @endforelse
</div>
@endsection
