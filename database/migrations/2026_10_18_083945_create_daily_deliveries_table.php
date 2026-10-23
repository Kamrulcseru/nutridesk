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
        Schema::create('daily_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions')->cascadeOnDelete();
            $table->date('delivery_date');
            $table->string('day_name');
            $table->enum('status', ['scheduled', 'preparing', 'out_for_delivery', 'delivered', 'paused_by_user', 'cancelled'])->default('scheduled');
            $table->string('fruits_summary')->nullable();
            $table->string('delivery_person')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->string('pause_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['delivery_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_deliveries');
    }
};
