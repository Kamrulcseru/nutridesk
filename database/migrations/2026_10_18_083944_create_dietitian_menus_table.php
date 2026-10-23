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
        Schema::create('dietitian_menus', function (Blueprint $table) {
            $table->id();
            $table->enum('day_of_week', ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
            $table->enum('health_condition', ['general', 'diabetes', 'kidney', 'heart'])->default('general');
            $table->string('title_en');
            $table->string('title_bn');
            $table->json('fruits_list');
            $table->unsignedInteger('calories_total')->default(75);
            $table->decimal('carbs_g', 5, 2)->default(15.00);
            $table->decimal('fiber_g', 5, 2)->default(3.50);
            $table->string('vitamins_focus')->nullable();
            $table->text('dietitian_advice_en')->nullable();
            $table->text('dietitian_advice_bn')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['day_of_week', 'health_condition'], 'day_condition_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dietitian_menus');
    }
};
