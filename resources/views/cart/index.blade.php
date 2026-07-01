@extends('layouts.app')
@section('title', 'سلة المشتريات — عبق الشرق')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
  <h1 class="text-2xl font-extrabold mb-8">سلة المشتريات</h1>

  @if (empty($lines))
    <div class="text-center py-20">
      <p class="text-muted">سلتك فارغة حاليًا.</p>
      <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-maroon text-cream font-bold rounded-lg px-7 py-2.5">تسوق الآن</a>
    </div>
  @else
    <div class="border border-sand rounded-2xl divide-y divide-sand">
      @foreach ($lines as $line)
        <div class="flex items-center gap-4 p-4">
          <div class="w-16 h-16 rounded-lg bg-sand overflow-hidden shrink-0">
            @if ($line['product']->image)
              <img src="{{ $line['product']->image }}" class="w-full h-full object-cover">
            @endif
          </div>

          <div class="flex-1">
            <a href="{{ route('products.show', $line['product']->slug) }}" class="font-medium hover:text-maroon">{{ $line['product']->name }}</a>
            <p class="text-sm text-muted mt-1">{{ $line['product']->price_formatted }}</p>
          </div>

          <form method="POST" action="{{ route('cart.update', $line['product']) }}" class="flex items-center gap-2">
            @csrf @method('PATCH')
            <input type="number" name="quantity" value="{{ $line['quantity'] }}" min="1"
              onchange="this.form.submit()"
              class="w-16 bg-sand rounded-lg px-2 py-1.5 text-center text-sm focus:outline-none">
          </form>

          <span class="font-bold w-24 text-left">{{ number_format($line['line_total']) }} ر.س</span>

          <form method="POST" action="{{ route('cart.remove', $line['product']) }}">
            @csrf @method('DELETE')
            <button class="text-muted hover:text-red-600 text-sm">حذف</button>
          </form>
        </div>
      @endforeach
    </div>

    <div class="flex justify-between items-center mt-8">
      <a href="{{ route('products.index') }}" class="text-sm text-maroon">متابعة التسوق</a>
      <div class="text-left">
        <p class="text-muted text-sm">الإجمالي الفرعي</p>
        <p class="text-2xl font-extrabold">{{ number_format($subtotal) }} ر.س</p>
      </div>
    </div>

    <a href="{{ route('checkout.show') }}" class="block w-full text-center bg-maroon text-cream font-bold rounded-lg py-3 mt-6 hover:bg-maroon2 transition">
      المتابعة لإتمام الطلب
    </a>
  @endif
</div>
@endsection
