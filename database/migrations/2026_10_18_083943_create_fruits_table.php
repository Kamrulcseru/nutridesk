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
        Schema::create('fruits', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn');
            $table->string('slug')->unique();
            $table->enum('origin', ['local', 'imported'])->default('local');
            $table->string('category')->default('fresh');
            $table->decimal('calories_per_100g', 6, 2)->default(50.00);
            $table->decimal('sugar_g_per_100g', 6, 2)->default(10.00);
            $table->decimal('potassium_mg_per_100g', 6, 2)->default(150.00);
            $table->decimal('fiber_g_per_100g', 6, 2)->default(2.50);
            $table->boolean('safe_for_diabetes')->default(true);
            $table->boolean('safe_for_kidney')->default(true);
            $table->boolean('safe_for_heart')->default(true);
            $table->string('season')->default('all_year');
            $table->text('benefits_en')->nullable();
            $table->text('benefits_bn')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fruits');
    }
};
