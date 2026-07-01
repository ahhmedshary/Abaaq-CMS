<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function show()
    {
        $cart = $this->cart->detailed();

        if (empty($cart['lines'])) {
            return redirect()->route('cart.index')->with('status', 'سلتك فارغة.');
        }

        return view('checkout.show', $cart);
    }

    public function process(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'city' => 'nullable|string|max:255',
            'payment_method' => 'required|in:stripe,cod',
        ]);

        $cart = $this->cart->detailed();
        if (empty($cart['lines'])) {
            return redirect()->route('cart.index')->with('status', 'سلتك فارغة.');
        }

        $shippingFee = config('store.flat_shipping_fee');
        $total = $cart['subtotal'] + $shippingFee;

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'shipping_address' => $data['shipping_address'],
            'city' => $data['city'] ?? null,
            'subtotal' => $cart['subtotal'],
            'shipping_fee' => $shippingFee,
            'total' => $total,
            'payment_method' => $data['payment_method'],
            'payment_status' => 'pending',
            'status' => 'new',
        ]);

        foreach ($cart['lines'] as $line) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $line['product']->id,
                'product_name' => $line['product']->name,
                'price' => $line['product']->price,
                'quantity' => $line['quantity'],
            ]);
        }

        if ($data['payment_method'] === 'cod') {
            $this->cart->clear();
            return redirect()->route('checkout.success', $order->order_number);
        }

        // Stripe Checkout Session, created via direct REST call —
        // avoids requiring the Stripe PHP SDK / composer install.
        return $this->startStripeCheckout($order, $cart['lines'], $shippingFee);
    }

    private function startStripeCheckout(Order $order, array $lines, int $shippingFee)
    {
        $secretKey = config('services.stripe.secret');

        if (! $secretKey) {
            // No Stripe key configured yet — fall back to COD so the demo never breaks.
            $order->update(['payment_method' => 'cod']);
            $this->cart->clear();
            return redirect()->route('checkout.success', $order->order_number)
                ->with('status', 'لم يتم إعداد بوابة الدفع بعد، تم تسجيل الطلب كدفع عند الاستلام.');
        }

        $currency = strtolower(config('store.currency_code', 'SAR'));
        $lineItems = [];

        foreach ($lines as $i => $line) {
            $lineItems["line_items[$i][price_data][currency]"] = $currency;
            $lineItems["line_items[$i][price_data][product_data][name]"] = $line['product']->name;
            $lineItems["line_items[$i][price_data][unit_amount]"] = $line['product']->price * 100;
            $lineItems["line_items[$i][quantity]"] = $line['quantity'];
        }

        $shippingIndex = count($lines);
        $lineItems["line_items[$shippingIndex][price_data][currency]"] = $currency;
        $lineItems["line_items[$shippingIndex][price_data][product_data][name]"] = 'الشحن';
        $lineItems["line_items[$shippingIndex][price_data][unit_amount]"] = $shippingFee * 100;
        $lineItems["line_items[$shippingIndex][quantity]"] = 1;

        $response = Http::asForm()->withToken($secretKey)
            ->post('https://api.stripe.com/v1/checkout/sessions', array_merge($lineItems, [
                'mode' => 'payment',
                'customer_email' => $order->customer_email,
                'success_url' => route('checkout.success', $order->order_number) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.show'),
                'metadata' => ['order_id' => $order->id],
            ]));

        if (! $response->successful()) {
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('checkout.show')
                ->withErrors(['payment' => 'تعذر الاتصال ببوابة الدفع. حاول مرة أخرى.']);
        }

        $session = $response->json();
        $order->update(['stripe_session_id' => $session['id']]);

        return redirect()->away($session['url']);
    }

    public function success(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // If returning from Stripe, verify payment status before clearing the cart.
        if ($order->payment_method === 'stripe' && $order->payment_status !== 'paid') {
            $secretKey = config('services.stripe.secret');
            if ($secretKey && $order->stripe_session_id) {
                $check = Http::withToken($secretKey)
                    ->get("https://api.stripe.com/v1/checkout/sessions/{$order->stripe_session_id}");

                if ($check->successful() && $check->json('payment_status') === 'paid') {
                    $order->update(['payment_status' => 'paid', 'status' => 'processing']);
                    $this->cart->clear();
                }
            }
        }

        return view('checkout.success', compact('order'));
    }
}
