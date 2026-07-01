<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'orderCount' => Order::count(),
            'newOrderCount' => Order::where('status', 'new')->count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'recentOrders' => Order::latest()->limit(6)->get(),
        ]);
    }
}
