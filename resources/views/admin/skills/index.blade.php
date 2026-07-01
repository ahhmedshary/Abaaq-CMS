@extends('admin.layouts.app')
@section('title', 'Skills')

@section('content')
<a href="{{ route('admin.skills.create') }}" class="inline-block bg-accent text-bg font-medium rounded-lg px-5 py-2 mb-6 hover:opacity-90 transition">
  + New skill group
</a>

<div class="border border-line rounded-xl divide-y divide-line">
  @forelse ($skills as $skill)
    <div class="flex items-center justify-between p-4">
      <div>
        <div class="font-medium">{{ $skill->group_name }}</div>
        <div class="text-sm text-muted">{{ implode(', ', $skill->items ?? []) }}</div>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.skills.edit', $skill) }}" class="text-sm text-muted hover:text-accent">Edit</a>
        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete this group?')">
          @csrf @method('DELETE')
          <button class="text-sm text-muted hover:text-red-400">Delete</button>
        </form>
      </div>
    </div>
  @empty
    <p class="p-6 text-muted text-sm">No skill groups yet.</p>
  @endforelse
</div>
@endsection
