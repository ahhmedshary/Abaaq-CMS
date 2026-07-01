@extends('admin.layouts.app')
@section('title', 'الطلبات')

@section('content')
<div class="border border-line rounded-xl divide-y divide-line">
  @forelse ($orders as $order)
    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-4 hover:bg-soft/40">
      <div>
        <div class="font-medium">{{ $order->order_number }} — {{ $order->customer_name }}</div>
        <div class="text-sm text-muted mt-1">{{ $order->created_at->format('Y-m-d H:i') }}</div>
      </div>
      <div class="flex items-center gap-4 text-sm">
        <span class="px-2 py-1 rounded-full bg-soft">{{ $order->status }}</span>
        <span class="font-medium">{{ number_format($order->total) }} ر.س</span>
      </div>
    </a>
  @empty
    <p class="p-6 text-muted text-sm">لا توجد طلبات بعد.</p>
  @endforelse
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
