<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        $orders = Order::query();
        $paid = (clone $orders)->where(function ($query) {
            $query->where('payment_status', 'Paid')
                ->orWhere('payment_status_normalized', 'paid');
        });

        $successOrders = (clone $orders)->where(function ($query) {
            $query->where('status', 'Delivered')->orWhere('order_status', 'Delivered');
        })->count();
        $delayedOrders = (clone $orders)->where(function ($query) {
            $query->where('status', 'Delayed')->orWhere('order_status', 'Delayed');
        })->count();
        $canceledOrders = (clone $orders)->where(function ($query) {
            $query->where('status', 'Canceled')->orWhere('order_status', 'Canceled');
        })->count();

        $paidRevenue = (int) $paid->sum(DB::raw('COALESCE(total_amount, total, 0)'));
        $pendingRevenue = (int) (clone $orders)->where(function ($query) {
            $query->where('payment_status', 'Pending')
                ->orWhere('payment_status_normalized', 'pending')
                ->orWhereNull('payment_status_normalized');
        })->sum(DB::raw('COALESCE(total_amount, total, 0)'));

        $chartRows = (clone $orders)
            ->selectRaw('DATE(created_at) as day, COALESCE(SUM(COALESCE(total_amount, total, 0)),0) as revenue')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'), 'desc')
            ->limit(14)
            ->get()
            ->reverse()
            ->values();

        return response()->json([
            'kpis' => [
                'success_orders' => $successOrders,
                'delayed_orders' => $delayedOrders,
                'canceled_orders' => $canceledOrders,
                'total_orders' => (clone $orders)->count(),
                'total_revenue' => $paidRevenue,
                'pending_revenue' => $pendingRevenue,
            ],
            'chart' => [
                'weeks' => $chartRows->pluck('day')->map(fn ($day) => (string) $day)->all(),
                'series' => [[
                    'month' => 'Revenue', 'color' => '#10B981',
                    'values' => $chartRows->pluck('revenue')->map(fn ($value) => (int) $value)->all(),
                ]],
            ],
            'live_orders' => (clone $orders)->with('items')->latest()->take(6)->get()->map(function ($order) {
                return [
                    'id' => '#'.$order->order_number,
                    'customer' => $order->customer_name ?: ($order->customer_email ?: 'ゲスト'),
                    'restaurant' => $order->items->first()?->name ?: 'NK-EATS',
                    'driver' => $order->driver ?: '—',
                    'amount' => $order->total_amount ?? $order->total,
                    'status' => $order->order_status ?: $order->status,
                ];
            }),
        ]);
    }

    public function orders()
    {
        $orders = Order::with('items')->latest()->get()->map(function ($order) {
            return [
                'id' => '#'.$order->order_number,
                'customer' => $order->customer_name ?: 'ゲスト',
                'restaurant' => $order->items->first()?->name ?: 'NK-EATS',
                'driver' => $order->driver ?: '—',
                'amount' => $order->total,
                'status' => $order->status,
                'paymentStatus' => $order->payment_status,
                'address' => $order->address,
                'phone' => $order->phone,
                'items' => $order->items->map(fn ($item) => [
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]),
                'createdAt' => $order->created_at?->toDateTimeString(),
            ];
        });

        return response()->json(['orders' => $orders]);
    }

    public function updateOrder(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => ['sometimes', 'in:Preparing,Pending,On the Way,Delivered,Delayed,Canceled'],
            'driver' => ['sometimes', 'nullable', 'string', 'max:100'],
        ]);

        $orderNumber = str_starts_with($id, '#') ? substr($id, 1) : $id;
        $order = Order::where('order_number', $orderNumber)->orWhere('id', $orderNumber)->first();

        if ($order) {
            $order->update(array_filter($validated, fn ($value) => $value !== null));
        }

        return response()->json(['id' => $id, 'updated' => $validated]);
    }

    public function updatePayment(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Paid,Failed,Refunded'],
            'reference' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:2000'],
        ]);

        if (DB::getSchemaBuilder()->hasTable('admin_payment_updates')) {
            DB::table('admin_payment_updates')->insert(array_merge($validated, [
                'payment_id' => $id,
                'admin_id' => $request->user()?->id,
                'audit_note' => $validated['note'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        return response()->json(['id' => $id, 'updated' => $validated]);
    }

    public function settleDriver(Request $request, int $id)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'handover_reference' => ['nullable', 'string', 'max:255'],
        ]);

        if (DB::getSchemaBuilder()->hasTable('driver_cod_settlements')) {
            DB::table('driver_cod_settlements')->insert([
                'driver_id' => $id,
                'amount' => $validated['amount'],
                'handover_reference' => $validated['handover_reference'] ?? null,
                'admin_id' => $request->user()?->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['driver_id' => $id, 'settled_amount' => (float) $validated['amount'], 'pending_cash' => 0]);
    }

    public function markPayout(Request $request, int $id)
    {
        $validated = $request->validate([
            'gross_sales' => ['required', 'numeric', 'min:0'],
            'commission' => ['sometimes', 'numeric', 'min:0', 'max:100'],
        ]);

        $commissionRate = (float) ($validated['commission'] ?? 15);
        $gross = (float) $validated['gross_sales'];
        $commission = round($gross * $commissionRate / 100, 2);
        $payout = round($gross - $commission, 2);

        if (DB::getSchemaBuilder()->hasTable('restaurant_payouts')) {
            DB::table('restaurant_payouts')->insert([
                'restaurant_id' => $id,
                'gross_sales' => $gross,
                'commission' => $commission,
                'payout_amount' => $payout,
                'status' => 'sent',
                'admin_id' => $request->user()?->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['restaurant_id' => $id, 'gross_sales' => $gross, 'commission' => $commission, 'payout_amount' => $payout, 'status' => 'sent']);
    }

    public function toggleRestaurant(Request $request, int $id)
    {
        $validated = $request->validate(['open' => ['required', 'boolean']]);
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update(['is_open' => (bool) $validated['open']]);

        return response()->json(['id' => $id, 'open' => $restaurant->is_open]);
    }

    public function toggleProduct(Request $request, int $id)
    {
        $validated = $request->validate([
            'in_stock' => ['sometimes', 'boolean'],
            'is_available' => ['sometimes', 'boolean'],
        ]);
        $product = Product::findOrFail($id);
        $available = $validated['is_available'] ?? $validated['in_stock'];
        $product->update(['is_available' => (bool) $available, 'in_stock' => (bool) $available]);

        return response()->json(['id' => $id, 'is_available' => $product->is_available, 'in_stock' => $product->in_stock]);
    }

    public function resolveComplaint(Request $request, int $id)
    {
        $validated = $request->validate([
            'reply' => ['nullable', 'string', 'max:2000'],
            'refund' => ['sometimes', 'boolean'],
        ]);

        return response()->json(['id' => $id, 'status' => 'Resolved', 'reply' => $validated['reply'] ?? null, 'refund' => (bool) ($validated['refund'] ?? false)]);
    }

    public function menu()
    {
        $restaurants = Restaurant::with('products')->orderBy('name')->get();

        return response()->json([
            'restaurants' => $restaurants,
            'products' => Product::with('restaurant')->latest()->get(),
        ]);
    }

    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'restaurant_id' => ['nullable', 'integer', 'exists:restaurants,id'],
            'restaurant' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'max:5120'],
            'image_path' => ['nullable', 'string', 'max:500'],
            'category' => ['nullable', 'string', 'max:255'],
            'in_stock' => ['sometimes', 'boolean'],
            'is_available' => ['sometimes', 'boolean'],
        ]);

        if (empty($validated['restaurant_id']) && !empty($validated['restaurant'])) {
            $restaurant = Restaurant::firstOrCreate(['name' => $validated['restaurant']]);
            $validated['restaurant_id'] = $restaurant->id;
        }

        $available = $validated['is_available'] ?? $validated['in_stock'] ?? true;
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'restaurant_id' => $validated['restaurant_id'] ?? null,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category' => $validated['category'] ?? '洋食',
            'image' => $imagePath,
            'image_path' => $imagePath,
            'in_stock' => (bool) $available,
            'is_available' => (bool) $available,
        ]);

        return response()->json(['product' => $this->serializeProduct($product)], 201);
    }

    public function updateProduct(Request $request, int $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'restaurant_id' => ['sometimes', 'nullable', 'integer', 'exists:restaurants,id'],
            'description' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'price' => ['sometimes', 'integer', 'min:1'],
            'image' => ['sometimes', 'image', 'max:5120'],
            'image_path' => ['sometimes', 'nullable', 'string', 'max:500'],
            'category' => ['sometimes', 'nullable', 'string', 'max:255'],
            'in_stock' => ['sometimes', 'boolean'],
            'is_available' => ['sometimes', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
            $validated['image_path'] = $imagePath;
        }

        if (array_key_exists('is_available', $validated) || array_key_exists('in_stock', $validated)) {
            $available = $validated['is_available'] ?? $validated['in_stock'];
            $validated['is_available'] = (bool) $available;
            $validated['in_stock'] = (bool) $available;
        }

        $product->update($validated);

        return response()->json(['product' => $this->serializeProduct($product->fresh('restaurant'))]);
    }

    public function deleteProduct(int $id)
    {
        $product = Product::findOrFail($id);
        if ($product->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();

        return response()->json(['deleted' => true]);
    }

    private function serializeProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => (int) $product->price,
            'category' => $product->category,
            'in_stock' => (bool) $product->in_stock,
            'is_available' => (bool) $product->is_available,
            'image' => $product->image,
            'image_url' => $product->image_path
                ? asset('storage/'.$product->image_path)
                : ($product->image ? asset($product->image) : null),
        ];
    }
}
