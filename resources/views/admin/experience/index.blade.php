@extends('admin.layouts.app')
@section('title', 'Experience')

@section('content')
<a href="{{ route('admin.experience.create') }}" class="inline-block bg-accent text-bg font-medium rounded-lg px-5 py-2 mb-6 hover:opacity-90 transition">
  + New entry
</a>

<div class="border border-line rounded-xl divide-y divide-line">
  @forelse ($rows as $row)
    <div class="flex items-center justify-between p-4">
      <div>
        <div class="font-medium">{{ $row->role }} · {{ $row->org }}</div>
        <div class="text-sm text-muted">{{ $row->period }}</div>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.experience.edit', $row) }}" class="text-sm text-muted hover:text-accent">Edit</a>
        <form method="POST" action="{{ route('admin.experience.destroy', $row) }}" onsubmit="return confirm('Delete this entry?')">
          @csrf @method('DELETE')
          <button class="text-sm text-muted hover:text-red-400">Delete</button>
        </form>
      </div>
    </div>
  @empty
    <p class="p-6 text-muted text-sm">No experience entries yet.</p>
  @endforelse
</div>
@endsection
