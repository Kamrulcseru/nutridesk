<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_bn',
        'code',
        'slug',
        'min_persons',
        'max_persons',
        'grams_per_person_daily',
        'price_7_days',
        'price_30_days',
        'price_per_person_per_day',
        'description_en',
        'description_bn',
        'features_en',
        'features_bn',
        'badge_text',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'features_en' => 'array',
            'features_bn' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'price_7_days' => 'decimal:2',
            'price_30_days' => 'decimal:2',
            'price_per_person_per_day' => 'decimal:2',
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}
