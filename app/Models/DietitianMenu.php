<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietitianMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'health_condition',
        'title_en',
        'title_bn',
        'fruits_list',
        'calories_total',
        'carbs_g',
        'fiber_g',
        'vitamins_focus',
        'dietitian_advice_en',
        'dietitian_advice_bn',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'fruits_list' => 'array',
            'carbs_g' => 'decimal:2',
            'fiber_g' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForDayAndCondition($query, string $day, string $condition = 'general')
    {
        return $query->where('day_of_week', strtolower($day))
                     ->where('health_condition', $condition)
                     ->where('is_active', true);
    }
}
