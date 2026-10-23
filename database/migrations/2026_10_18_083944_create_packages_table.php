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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn');
            $table->string('code')->unique()->comment('shakti, bondhu, office');
            $table->string('slug')->unique();
            $table->unsignedInteger('min_persons')->default(1);
            $table->unsignedInteger('max_persons')->default(1);
            $table->unsignedInteger('grams_per_person_daily')->default(120);
            $table->decimal('price_7_days', 10, 2);
            $table->decimal('price_30_days', 10, 2);
            $table->decimal('price_per_person_per_day', 10, 2);
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->json('features_en')->nullable();
            $table->json('features_bn')->nullable();
            $table->string('badge_text')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
