<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
            $table->string('role')->default('customer')->after('is_admin');
        });

        Schema::create('admin_payment_updates', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('status');
            $table->string('reference')->nullable();
            $table->text('audit_note')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('driver_cod_settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->decimal('amount', 12, 2);
            $table->string('handover_reference')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('restaurant_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->decimal('gross_sales', 12, 2);
            $table->decimal('commission', 12, 2);
            $table->decimal('payout_amount', 12, 2);
            $table->string('status')->default('pending');
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_payouts');
        Schema::dropIfExists('driver_cod_settlements');
        Schema::dropIfExists('admin_payment_updates');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'role']);
        });
    }
};
