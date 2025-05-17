<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_provider_id',
        'province_code',
        'province_name',
        'base_fee',
        'weight_fee',
        'distance_fee',
        'extra_fees',
        'note'
    ];

    protected $casts = [
        'base_fee' => 'decimal:2',
        'weight_fee' => 'decimal:2',
        'distance_fee' => 'decimal:2',
        'extra_fees' => 'array'
    ];

    public function provider()
    {
        return $this->belongsTo(ShippingProvider::class, 'shipping_provider_id');
    }
}
