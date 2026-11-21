<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('image');
            $table->boolean('is_available')->default(true)->after('in_stock');
        });

        DB::table('products')->orderBy('id')->each(function ($product) {
            DB::table('products')->where('id', $product->id)->update([
                'image_path' => $product->image,
                'is_available' => (bool) $product->in_stock,
            ]);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            $table->text('delivery_address')->nullable()->after('customer_phone');
            $table->integer('total_amount')->nullable()->after('total');
            $table->string('payment_method')->default('stripe')->after('total_amount');
            $table->string('stripe_payment_intent_id')->nullable()->after('stripe_session_id');
            $table->string('order_status')->nullable()->after('status');
            $table->string('payment_status_normalized')->nullable()->after('payment_status');
        });

        DB::table('orders')->orderBy('id')->each(function ($order) {
            DB::table('orders')->where('id', $order->id)->update([
                'customer_email' => $order->user_id ? DB::table('users')->where('id', $order->user_id)->value('email') : null,
                'customer_phone' => $order->phone,
                'delivery_address' => $order->address,
                'total_amount' => $order->total,
                'order_status' => $order->status,
                'payment_status_normalized' => strtolower((string) $order->payment_status),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_email', 'customer_phone', 'delivery_address', 'total_amount',
                'payment_method', 'stripe_payment_intent_id', 'order_status', 'payment_status_normalized',
            ]);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'is_available']);
        });
    }
};
