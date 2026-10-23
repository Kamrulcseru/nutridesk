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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('password')->comment('super_admin, staff, dietitian, customer');
            $table->string('phone')->nullable()->after('email');
            $table->string('office_name')->nullable()->after('role');
            $table->text('office_address')->nullable()->after('office_name');
            $table->string('office_floor')->nullable()->after('office_address');
            $table->string('desk_number')->nullable()->after('office_floor');
            $table->string('health_condition')->default('general')->after('desk_number')->comment('general, diabetes, kidney, heart');
            $table->text('allergies_notes')->nullable()->after('health_condition');
            $table->string('preferred_delivery_time')->default('10:00 AM - 11:30 AM')->after('allergies_notes');
            $table->string('preferred_language')->default('bn')->after('preferred_delivery_time');
            $table->boolean('is_active')->default(true)->after('preferred_language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'office_name',
                'office_address',
                'office_floor',
                'desk_number',
                'health_condition',
                'allergies_notes',
                'preferred_delivery_time',
                'preferred_language',
                'is_active',
            ]);
        });
    }
};
