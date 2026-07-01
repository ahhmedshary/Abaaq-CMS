@extends('layouts.app')
@section('title', 'تم استلام طلبك — عبق الشرق')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-24 text-center">
  <div class="w-16 h-16 mx-auto rounded-full bg-green-100 text-green-600 flex items-center justify-center text-2xl">✓</div>
  <h1 class="text-2xl font-extrabold mt-6">شكرًا لك، تم استلام طلبك</h1>
  <p class="text-muted mt-3">رقم الطلب: <span class="font-bold text-ink">{{ $order->order_number }}</span></p>

  <div class="border border-sand rounded-2xl p-6 mt-8 text-right">
    <div class="flex justify-between text-sm mb-2"><span class="text-muted">حالة الدفع</span><span>{{ $order->payment_status === 'paid' ? 'تم الدفع' : ($order->payment_method === 'cod' ? 'الدفع عند الاستلام' : 'قيد المعالجة') }}</span></div>
    <div class="flex justify-between text-sm mb-2"><span class="text-muted">الإجمالي</span><span>{{ number_format($order->total) }} ر.س</span></div>
    <div class="flex justify-between text-sm"><span class="text-muted">سيتم التواصل معك على</span><span>{{ $order->customer_phone }}</span></div>
  </div>

  <a href="{{ route('products.index') }}" class="inline-block mt-8 bg-maroon text-cream font-bold rounded-lg px-8 py-3">متابعة التسوق</a>
</div>
@endsection
