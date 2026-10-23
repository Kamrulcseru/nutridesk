<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subscription_id',
        'package_id',
        'order_type',
        'subtotal',
        'discount',
        'total_amount',
        'payment_method',
        'payment_trx_id',
        'payment_status',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'customer_notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
