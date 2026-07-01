@extends('layouts.app')
@section('title', 'إتمام الطلب — عبق الشرق')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
  <h1 class="text-2xl font-extrabold mb-8">إتمام الطلب</h1>

  <div class="grid md:grid-cols-3 gap-10">
    <form method="POST" action="{{ route('checkout.process') }}" class="md:col-span-2 space-y-5" id="checkout-form">
      @csrf

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="text-sm text-muted block mb-1">الاسم الكامل</label>
          <input name="customer_name" value="{{ old('customer_name') }}" required
            class="w-full bg-sand rounded-lg px-4 py-2.5 focus:outline-none">
        </div>
        <div>
          <label class="text-sm text-muted block mb-1">رقم الجوال</label>
          <input name="customer_phone" value="{{ old('customer_phone') }}" required
            class="w-full bg-sand rounded-lg px-4 py-2.5 focus:outline-none">
        </div>
      </div>

      <div>
        <label class="text-sm text-muted block mb-1">البريد الإلكتروني</label>
        <input type="email" name="customer_email" value="{{ old('customer_email') }}" required
          class="w-full bg-sand rounded-lg px-4 py-2.5 focus:outline-none">
      </div>

      <div>
        <label class="text-sm text-muted block mb-1">العنوان التفصيلي</label>
        <textarea name="shipping_address" rows="3" required
          class="w-full bg-sand rounded-lg px-4 py-2.5 focus:outline-none">{{ old('shipping_address') }}</textarea>
      </div>

      <div>
        <label class="text-sm text-muted block mb-1">المدينة</label>
        <input name="city" value="{{ old('city') }}"
          class="w-full bg-sand rounded-lg px-4 py-2.5 focus:outline-none">
      </div>

      <div>
        <label class="text-sm text-muted block mb-3">طريقة الدفع</label>
        <div class="space-y-2">
          <label class="flex items-center gap-3 border border-sand rounded-lg px-4 py-3 cursor-pointer">
            <input type="radio" name="payment_method" value="stripe" checked>
            <span>الدفع الإلكتروني (بطاقة ائتمان عبر Stripe)</span>
          </label>
          <label class="flex items-center gap-3 border border-sand rounded-lg px-4 py-3 cursor-pointer">
            <input type="radio" name="payment_method" value="cod">
            <span>الدفع عند الاستلام</span>
          </label>
        </div>
      </div>

      <button type="submit" class="w-full bg-maroon text-cream font-bold rounded-lg py-3 hover:bg-maroon2 transition">
        تأكيد الطلب
      </button>
    </form>

    <div class="border border-sand rounded-2xl p-6 h-fit">
      <h2 class="font-bold mb-4">ملخص الطلب</h2>
      <div class="space-y-3 text-sm">
        @foreach ($lines as $line)
          <div class="flex justify-between">
            <span class="text-muted">{{ $line['product']->name }} × {{ $line['quantity'] }}</span>
            <span>{{ number_format($line['line_total']) }} ر.س</span>
          </div>
        @endforeach
      </div>
      <div class="border-t border-sand mt-4 pt-4 space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-muted">الإجمالي الفرعي</span><span>{{ number_format($subtotal) }} ر.س</span></div>
        <div class="flex justify-between"><span class="text-muted">الشحن</span><span>{{ number_format(config('store.flat_shipping_fee')) }} ر.س</span></div>
        <div class="flex justify-between font-bold text-base pt-2 border-t border-sand">
          <span>الإجمالي</span>
          <span>{{ number_format($subtotal + config('store.flat_shipping_fee')) }} ر.س</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
