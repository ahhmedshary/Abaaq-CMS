@extends('admin.layouts.app')
@section('title', 'لوحة التحكم')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  <a href="{{ route('admin.products.index') }}" class="border border-line rounded-xl p-5 hover:border-accent transition">
    <div class="text-3xl font-semibold">{{ $productCount }}</div>
    <div class="text-sm text-muted mt-1">منتج</div>
  </a>
  <a href="{{ route('admin.categories.index') }}" class="border border-line rounded-xl p-5 hover:border-accent transition">
    <div class="text-3xl font-semibold">{{ $categoryCount }}</div>
    <div class="text-sm text-muted mt-1">فئة</div>
  </a>
  <a href="{{ route('admin.orders.index') }}" class="border border-line rounded-xl p-5 hover:border-accent transition">
    <div class="text-3xl font-semibold">{{ $orderCount }}</div>
    <div class="text-sm text-muted mt-1">طلب ({{ $newOrderCount }} جديد)</div>
  </a>
  <div class="border border-line rounded-xl p-5">
    <div class="text-3xl font-semibold">{{ number_format($revenue) }}</div>
    <div class="text-sm text-muted mt-1">إجمالي المبيعات (ر.س)</div>
  </div>
</div>

<div class="mt-10 border border-line rounded-xl">
  <h2 class="font-semibold p-5 border-b border-line">أحدث الطلبات</h2>
  <div class="divide-y divide-line">
    @forelse ($recentOrders as $order)
      <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-4 hover:bg-soft/40">
        <span>{{ $order->order_number }} — {{ $order->customer_name }}</span>
        <span class="text-muted text-sm">{{ number_format($order->total) }} ر.س</span>
      </a>
    @empty
      <p class="p-5 text-muted text-sm">لا توجد طلبات بعد.</p>
    @endforelse
  </div>
</div>
@endsection
