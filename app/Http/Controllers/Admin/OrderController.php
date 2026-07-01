<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', ['orders' => Order::latest()->paginate(20)]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', ['order' => $order->load('items')]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:new,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update($data);
        return back()->with('status', 'تم تحديث حالة الطلب.');
    }
}
