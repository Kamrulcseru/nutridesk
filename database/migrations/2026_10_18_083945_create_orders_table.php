<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained('subscriptions')->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->enum('order_type', ['subscription', 'single_order'])->default('subscription');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['bkash', 'nagad', 'card', 'cash_on_delivery', 'corporate_invoice'])->default('bkash');
            $table->string('payment_trx_id')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('status', ['pending', 'processing', 'active', 'completed', 'cancelled'])->default('pending');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('delivery_address');
            $table->text('customer_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
