<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'delivery_date',
        'day_name',
        'status',
        'fruits_summary',
        'delivery_person',
        'delivered_at',
        'pause_reason',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'delivery_date' => 'date',
            'delivered_at' => 'datetime',
        ];
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
