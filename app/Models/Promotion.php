<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'discount_type', 'discount_value',
        'minimum_purchase', 'usage_limit', 'used_count', 'is_active',
        'start_date', 'end_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'discount_value' => 'decimal:2',
        'minimum_purchase' => 'decimal:2',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_products');
    }

    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }
    
    public function isValid()
    {
        $now = now();
        return $this->is_active && 
               $now->greaterThanOrEqualTo($this->start_date) && 
               $now->lessThanOrEqualTo($this->end_date) &&
               ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }
} 