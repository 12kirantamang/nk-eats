<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeCheckoutController extends Controller
{
    public function show()
    {
        return view('checkout');
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'cart' => ['required', 'array', 'min:1'],
            'cart.*.id' => ['nullable', 'integer'],
            'cart.*.name' => ['required', 'string', 'max:255'],
            'cart.*.price' => ['required', 'integer', 'min:1'],
            'cart.*.qty' => ['required', 'integer', 'min:1'],
            'delivery' => ['required', 'in:delivery,pickup'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:30'],
            'payment_method' => ['sometimes', 'in:stripe,cod'],
        ]);

        if ($validated['delivery'] === 'delivery' && (!$validated['address'] || !$validated['phone'])) {
            return response()->json(['message' => 'お届け先住所と電話番号を入力してください。'], 422);
        }

        $subtotal = collect($validated['cart'])->sum(fn (array $item) => $item['price'] * $item['qty']);
        $deliveryFee = $validated['delivery'] === 'delivery' && $subtotal < 3000 ? 300 : 0;
        $total = $subtotal + $deliveryFee;
        $user = $request->user();

        $order = Order::create([
            'order_number' => 'FX'.now()->format('ymdHis').random_int(10, 99),
            'user_id' => $user?->id,
            'customer_name' => $user?->name,
            'customer_email' => $user?->email,
            'customer_phone' => $validated['phone'] ?? null,
            'delivery_address' => $validated['delivery'] === 'pickup' ? '店頭受取' : ($validated['address'] ?? null),
            'delivery' => $validated['delivery'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
            'total_amount' => $total,
            'payment_method' => $validated['payment_method'] ?? 'stripe',
            'payment_status' => 'Pending',
            'payment_status_normalized' => 'pending',
            'status' => 'Pending',
            'order_status' => 'Pending',
        ]);

        foreach ($validated['cart'] as $cartItem) {
            $product = isset($cartItem['id'])
                ? Product::find($cartItem['id'])
                : Product::where('name', $cartItem['name'])->first();

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product?->id,
                'name' => $cartItem['name'],
                'price' => $cartItem['price'],
                'quantity' => $cartItem['qty'],
            ]);
        }

        if (($validated['payment_method'] ?? 'stripe') === 'cod') {
            $order->update([
                'payment_status' => 'Pending',
                'payment_status_normalized' => 'pending',
            ]);

            return response()->json(['success' => true, 'order_number' => $order->order_number]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = collect($validated['cart'])->map(fn (array $item) => [
            'quantity' => $item['qty'],
            'price_data' => [
                'currency' => 'jpy',
                'unit_amount' => $item['price'],
                'product_data' => ['name' => $item['name']],
            ],
        ])->values()->all();

        if ($deliveryFee > 0) {
            $lineItems[] = [
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $deliveryFee,
                    'product_data' => ['name' => '配達料'],
                ],
            ];
        }

        try {
            $session = Session::create([
                'mode' => 'payment',
                'line_items' => $lineItems,
                'success_url' => url('/checkout/success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url('/'),
                'customer_email' => $user?->email,
                'metadata' => [
                    'order_number' => $order->order_number,
                    'delivery' => $validated['delivery'],
                    'address' => $validated['address'] ?? '',
                    'phone' => $validated['phone'] ?? '',
                ],
                'phone_number_collection' => ['enabled' => true],
            ]);

            $order->update(['stripe_session_id' => $session->id]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => '決済サービスとの通信に失敗しました。しばらくしてからもう一度お試しください。',
            ], 502);
        }

        return response()->json(['url' => $session->url]);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect('/');
        }

        $order = Order::where('stripe_session_id', $sessionId)->first();

        if ($order) {
            $paymentIntentId = null;

            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $session = Session::retrieve($sessionId);
                $paymentIntentId = $session->payment_intent;
            } catch (\Throwable $exception) {
                report($exception);
            }

            $order->update([
                'payment_status' => 'Paid',
                'payment_status_normalized' => 'paid',
                'stripe_payment_intent_id' => $paymentIntentId,
                'status' => 'Preparing',
                'order_status' => 'Preparing',
            ]);
        }

        return view('checkout-success', ['sessionId' => $sessionId]);
    }
}
