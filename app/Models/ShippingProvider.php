<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'logo_url',
        'api_key',
        'api_secret',
        'api_endpoint',
        'api_settings',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'api_settings' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function shippingFees()
    {
        return $this->hasMany(ShippingFee::class);
    }
}
