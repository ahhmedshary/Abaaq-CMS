<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StoreController extends Controller
{
    /** GET /api/store/home */
    public function home(): JsonResponse
    {
        $sections = \App\Models\PageSection::where('page', 'home')
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn($s) => [
                'type'     => $s->type,
                'settings' => $s->settings ?? [],
            ]);

        // Fetch data for dynamic sections
        $featured = Product::where('is_published', true)->where('is_featured', true)
            ->orderBy('sort_order')->limit(12)->get()->map(fn($p) => $this->formatProduct($p));

        $on_offer = Product::where('is_published', true)->where('is_on_offer', true)
            ->orderBy('sort_order')->limit(12)->get()->map(fn($p) => $this->formatProduct($p));

        $latest = Product::where('is_published', true)
            ->latest()->limit(12)->get()->map(fn($p) => $this->formatProduct($p));

        $categories = \App\Models\Category::orderBy('sort_order')->get()
            ->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'slug' => $c->slug, 'image' => $c->image]);

        return response()->json([
            'sections'   => $sections,
            'categories' => $categories,
            'featured'   => $featured,
            'on_offer'   => $on_offer,
            'latest'     => $latest,
        ]);
    }

    /** GET /api/store/products?category=slug&page=1 */
    public function products(Request $request): JsonResponse
    {
        $query = Product::where('is_published', true)->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        $paginated = $query->orderBy('sort_order')->paginate(12);

        return response()->json([
            'data'         => collect($paginated->items())->map(fn($p) => $this->formatProduct($p)),
            'current_page' => $paginated->currentPage(),
            'last_page'    => $paginated->lastPage(),
            'total'        => $paginated->total(),
            'categories'   => Category::orderBy('sort_order')->get()
                ->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'slug' => $c->slug]),
        ]);
    }

    /** GET /api/store/products/{slug} */
    public function product(string $slug): JsonResponse
    {
        $product = Product::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $related = Product::where('is_published', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)->get()->map(fn($p) => $this->formatProduct($p));

        return response()->json([
            'product' => $this->formatProduct($product),
            'related' => $related,
        ]);
    }

    /** POST /api/store/checkout */
    public function checkout(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email',
            'customer_phone'   => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'city'             => 'nullable|string',
            'payment_method'   => 'required|in:stripe,cod',
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Re-price server-side — never trust client prices
        $products = Product::whereIn('id', collect($data['items'])->pluck('id'))->get()->keyBy('id');

        $lines    = [];
        $subtotal = 0;

        foreach ($data['items'] as $item) {
            $product = $products->get($item['id']);
            if (! $product) continue;

            $lineTotal = $product->price * $item['quantity'];
            $subtotal += $lineTotal;

            $lines[] = [
                'product'    => $product,
                'quantity'   => $item['quantity'],
                'line_total' => $lineTotal,
            ];
        }

        $shippingFee = config('store.flat_shipping_fee', 25);
        $total       = $subtotal + $shippingFee;

        $order = Order::create([
            'order_number'     => Order::generateOrderNumber(),
            'customer_name'    => $data['customer_name'],
            'customer_email'   => $data['customer_email'],
            'customer_phone'   => $data['customer_phone'],
            'shipping_address' => $data['shipping_address'],
            'city'             => $data['city'] ?? null,
            'subtotal'         => $subtotal,
            'shipping_fee'     => $shippingFee,
            'total'            => $total,
            'payment_method'   => $data['payment_method'],
            'payment_status'   => 'pending',
            'status'           => 'new',
        ]);

        foreach ($lines as $line) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $line['product']->id,
                'product_name' => $line['product']->name,
                'price'        => $line['product']->price,
                'quantity'     => $line['quantity'],
            ]);
        }

        if ($data['payment_method'] === 'cod') {
            return response()->json([
                'status'       => 'success',
                'order_number' => $order->order_number,
                'redirect'     => null,
            ]);
        }

        // Stripe Checkout
        $secretKey = config('services.stripe.secret');
        if (! $secretKey) {
            $order->update(['payment_method' => 'cod']);
            return response()->json(['status' => 'success', 'order_number' => $order->order_number]);
        }

        $currency  = strtolower(config('store.currency_code', 'SAR'));
        $lineItems = [];

        foreach ($lines as $i => $line) {
            $lineItems["line_items[$i][price_data][currency]"]                    = $currency;
            $lineItems["line_items[$i][price_data][product_data][name]"]          = $line['product']->name;
            $lineItems["line_items[$i][price_data][unit_amount]"]                 = $line['product']->price * 100;
            $lineItems["line_items[$i][quantity]"]                                = $line['quantity'];
        }

        $si = count($lines);
        $lineItems["line_items[$si][price_data][currency]"]                    = $currency;
        $lineItems["line_items[$si][price_data][product_data][name]"]          = 'الشحن';
        $lineItems["line_items[$si][price_data][unit_amount]"]                 = $shippingFee * 100;
        $lineItems["line_items[$si][quantity]"]                                = 1;

        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');

        $response = Http::asForm()->withToken($secretKey)
            ->post('https://api.stripe.com/v1/checkout/sessions', array_merge($lineItems, [
                'mode'           => 'payment',
                'customer_email' => $order->customer_email,
                'success_url'    => "$frontendUrl/success/{$order->order_number}?session_id={CHECKOUT_SESSION_ID}",
                'cancel_url'     => "$frontendUrl/checkout",
                'metadata'       => ['order_id' => $order->id],
            ]));

        if (! $response->successful()) {
            return response()->json(['status' => 'error', 'message' => 'تعذر الاتصال ببوابة الدفع'], 500);
        }

        $session = $response->json();
        $order->update(['stripe_session_id' => $session['id']]);

        return response()->json([
            'status'       => 'stripe',
            'order_number' => $order->order_number,
            'redirect'     => $session['url'],
        ]);
    }

    /** GET /api/store/order/{orderNumber} */
    public function order(string $orderNumber): JsonResponse
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();

        return response()->json([
            'order_number'   => $order->order_number,
            'status'         => $order->status,
            'payment_status' => $order->payment_status,
            'payment_method' => $order->payment_method,
            'total'          => $order->total,
            'customer_name'  => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'items'          => $order->items->map(fn($i) => [
                'name'     => $i->product_name,
                'price'    => $i->price,
                'quantity' => $i->quantity,
            ]),
        ]);
    }

    private function formatProduct(Product $p): array
    {
        return [
            'id'              => $p->id,
            'name'            => $p->name,
            'slug'            => $p->slug,
            'description'     => $p->description,
            'price'           => $p->price,
            'compare_price'   => $p->compare_price,
            'price_formatted' => $p->price_formatted,
            'compare_price_formatted' => $p->compare_price_formatted,
            'discount_percent' => $p->discount_percent,
            'image'           => $p->image,
            'is_featured'     => $p->is_featured,
            'is_on_offer'     => $p->is_on_offer,
            'category'        => $p->category ? ['name' => $p->category->name, 'slug' => $p->category->slug] : null,
        ];
    }
}
