@extends('admin.layouts.app')
@section('title', 'طلب ' . $order->order_number)

@section('content')
<div class="grid md:grid-cols-3 gap-8">
  <div class="md:col-span-2 border border-line rounded-xl p-6">
    <h2 class="font-semibold mb-4">المنتجات</h2>
    <div class="space-y-3">
      @foreach ($order->items as $item)
        <div class="flex justify-between text-sm">
          <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
          <span>{{ number_format($item->price * $item->quantity) }} ر.س</span>
        </div>
      @endforeach
    </div>
    <div class="border-t border-line mt-4 pt-4 space-y-2 text-sm">
      <div class="flex justify-between"><span class="text-muted">الإجمالي الفرعي</span><span>{{ number_format($order->subtotal) }} ر.س</span></div>
      <div class="flex justify-between"><span class="text-muted">الشحن</span><span>{{ number_format($order->shipping_fee) }} ر.س</span></div>
      <div class="flex justify-between font-bold"><span>الإجمالي</span><span>{{ number_format($order->total) }} ر.س</span></div>
    </div>
  </div>

  <div class="space-y-6">
    <div class="border border-line rounded-xl p-6">
      <h2 class="font-semibold mb-3">بيانات العميل</h2>
      <p class="text-sm">{{ $order->customer_name }}</p>
      <p class="text-sm text-muted">{{ $order->customer_phone }}</p>
      <p class="text-sm text-muted">{{ $order->customer_email }}</p>
      <p class="text-sm text-muted mt-2">{{ $order->shipping_address }}، {{ $order->city }}</p>
    </div>

    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="border border-line rounded-xl p-6 space-y-4">
      @csrf @method('PATCH')
      <div>
        <label class="text-sm text-muted block mb-1">حالة الطلب</label>
        <select name="status" class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
          @foreach (['new' => 'جديد', 'processing' => 'قيد المعالجة', 'shipped' => 'تم الشحن', 'delivered' => 'تم التسليم', 'cancelled' => 'ملغي'] as $val => $label)
            <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="text-sm text-muted block mb-1">حالة الدفع</label>
        <select name="payment_status" class="w-full bg-transparent border border-line rounded-lg px-4 py-2 focus:outline-none focus:border-accent">
          @foreach (['pending' => 'قيد الانتظار', 'paid' => 'تم الدفع', 'failed' => 'فشل'] as $val => $label)
            <option value="{{ $val }}" {{ $order->payment_status === $val ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="w-full bg-accent text-bg font-medium rounded-lg py-2.5 hover:opacity-90 transition">حفظ</button>
    </form>
  </div>
</div>
@endsection
