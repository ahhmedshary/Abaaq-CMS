<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    const SESSION_KEY = 'cart';

    public function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->items();
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        Session::put(self::SESSION_KEY, $cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->items();
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }
        Session::put(self::SESSION_KEY, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->items();
        unset($cart[$productId]);
        Session::put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /** Returns Product models with a `quantity` attribute attached, plus totals. */
    public function detailed(): array
    {
        $cart = $this->items();
        if (empty($cart)) {
            return ['lines' => [], 'subtotal' => 0, 'count' => 0];
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $lines = [];
        $subtotal = 0;
        $count = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $products->get($productId);
            if (! $product) continue;

            $lineTotal = $product->price * $quantity;
            $subtotal += $lineTotal;
            $count += $quantity;

            $lines[] = [
                'product' => $product,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        return ['lines' => $lines, 'subtotal' => $subtotal, 'count' => $count];
    }

    public function count(): int
    {
        return array_sum($this->items());
    }
}
