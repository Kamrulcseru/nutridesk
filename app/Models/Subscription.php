<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_code',
        'user_id',
        'package_id',
        'plan_duration',
        'health_condition',
        'total_persons',
        'daily_grams',
        'delivery_office_name',
        'delivery_office_address',
        'delivery_floor',
        'delivery_desk',
        'delivery_phone',
        'delivery_time_slot',
        'delivery_days_type',
        'start_date',
        'end_date',
        'total_delivery_days',
        'delivered_days_count',
        'paused_days_count',
        'total_amount',
        'payment_status',
        'subscription_status',
        'special_notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_amount' => 'decimal:2',
            'total_persons' => 'integer',
            'daily_grams' => 'integer',
            'total_delivery_days' => 'integer',
            'delivered_days_count' => 'integer',
            'paused_days_count' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function dailyDeliveries()
    {
        return $this->hasMany(DailyDelivery::class)->orderBy('delivery_date', 'asc');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('subscription_status', 'active');
    }
}
