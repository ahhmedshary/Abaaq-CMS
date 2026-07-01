<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index()
    {
        return view('cart.index', $this->cart->detailed());
    }

    public function add(Request $request, Product $product)
    {
        $this->cart->add($product->id, max(1, (int) $request->input('quantity', 1)));
        return back()->with('status', 'تمت إضافة المنتج إلى السلة.');
    }

    public function update(Request $request, Product $product)
    {
        $this->cart->update($product->id, (int) $request->input('quantity', 1));
        return back()->with('status', 'تم تحديث السلة.');
    }

    public function remove(Product $product)
    {
        $this->cart->remove($product->id);
        return back()->with('status', 'تم حذف المنتج من السلة.');
    }
}
