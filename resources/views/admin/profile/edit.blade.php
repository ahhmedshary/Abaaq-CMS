@extends('admin.layouts.app')
@section('title', 'Profile')

@section('content')
<form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
  @csrf @method('PUT')

  <div>
    <label class="text-sm text-muted block mb-1">Full name</label>
    <input name="name" value="{{ old('name', $profile->name) }}" required
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Role / title</label>
    <input name="role" value="{{ old('role', $profile->role) }}" required
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Tagline</label>
    <textarea name="tagline" rows="2" required
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ old('tagline', $profile->tagline) }}</textarea>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div>
      <label class="text-sm text-muted block mb-1">Location</label>
      <input name="location" value="{{ old('location', $profile->location) }}"
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
    <div>
      <label class="text-sm text-muted block mb-1">Email</label>
      <input type="email" name="email" value="{{ old('email', $profile->email) }}" required
        class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
    </div>
  </div>

  <div>
    <label class="text-sm text-muted block mb-1">Avatar</label>
    @if ($profile->avatar)
      <img src="{{ $profile->avatar }}" class="w-16 h-16 rounded-full object-cover mb-2 border border-line">
    @endif
    <input type="file" name="avatar" accept="image/*" class="text-sm text-muted">
  </div>

  <div>
    <label class="text-sm text-muted block mb-2">Social links</label>
    @php $social = old('social', $profile->social ?? []); @endphp
    <div class="space-y-2">
      @for ($i = 0; $i < 4; $i++)
        <div class="grid grid-cols-2 gap-2">
          <input name="social_labels[]" placeholder="Label (e.g. Twitter)" value="{{ $social[$i]['label'] ?? '' }}"
            class="bg-transparent border border-line rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-accent">
          <input name="social_urls[]" placeholder="https://..." value="{{ $social[$i]['url'] ?? '' }}"
            class="bg-transparent border border-line rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-accent">
        </div>
      @endfor
    </div>
  </div>

  <div>
    <label class="text-sm text-muted block mb-2">Stats (e.g. "08" / "Years in practice")</label>
    @php $stats = old('stats', $profile->stats ?? []); @endphp
    <div class="space-y-2">
      @for ($i = 0; $i < 4; $i++)
        <div class="grid grid-cols-2 gap-2">
          <input name="stat_values[]" placeholder="Value (e.g. 08)" value="{{ $stats[$i]['value'] ?? '' }}"
            class="bg-transparent border border-line rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-accent">
          <input name="stat_labels[]" placeholder="Label" value="{{ $stats[$i]['label'] ?? '' }}"
            class="bg-transparent border border-line rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-accent">
        </div>
      @endfor
    </div>
  </div>

  <button type="submit" class="bg-accent text-bg font-medium rounded-lg px-6 py-2.5 hover:opacity-90 transition">
    Save changes
  </button>
</form>
@endsection
