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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_code')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->enum('plan_duration', ['7_days', '30_days'])->default('30_days');
            $table->enum('health_condition', ['general', 'diabetes', 'kidney', 'heart'])->default('general');
            $table->unsignedInteger('total_persons')->default(1);
            $table->unsignedInteger('daily_grams')->default(120);
            $table->string('delivery_office_name');
            $table->text('delivery_office_address');
            $table->string('delivery_floor')->nullable();
            $table->string('delivery_desk')->nullable();
            $table->string('delivery_phone');
            $table->string('delivery_time_slot')->default('10:00 AM - 11:30 AM');
            $table->enum('delivery_days_type', ['office_days_sun_thu', 'office_days_mon_fri', 'all_days'])->default('office_days_sun_thu');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('total_delivery_days')->default(22);
            $table->unsignedInteger('delivered_days_count')->default(0);
            $table->unsignedInteger('paused_days_count')->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('subscription_status', ['active', 'paused', 'completed', 'cancelled'])->default('active');
            $table->text('special_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
