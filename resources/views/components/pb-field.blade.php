@props(['label', 'name', 'value' => '', 'type' => 'text'])

<div>
  <label class="text-sm text-muted block mb-1">{{ $label }}</label>
  @if ($type === 'textarea')
    <textarea name="{{ $name }}" rows="3"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">{{ $value }}</textarea>
  @else
    <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}"
      class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
  @endif
</div>
