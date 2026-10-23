<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fruit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_bn',
        'slug',
        'origin',
        'category',
        'calories_per_100g',
        'sugar_g_per_100g',
        'potassium_mg_per_100g',
        'fiber_g_per_100g',
        'safe_for_diabetes',
        'safe_for_kidney',
        'safe_for_heart',
        'season',
        'benefits_en',
        'benefits_bn',
        'image_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'calories_per_100g' => 'decimal:2',
            'sugar_g_per_100g' => 'decimal:2',
            'potassium_mg_per_100g' => 'decimal:2',
            'fiber_g_per_100g' => 'decimal:2',
            'safe_for_diabetes' => 'boolean',
            'safe_for_kidney' => 'boolean',
            'safe_for_heart' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForDiabetes($query)
    {
        return $query->where('is_active', true)->where('safe_for_diabetes', true);
    }

    public function scopeForKidney($query)
    {
        return $query->where('is_active', true)->where('safe_for_kidney', true);
    }

    public function scopeForHeart($query)
    {
        return $query->where('is_active', true)->where('safe_for_heart', true);
    }
}
