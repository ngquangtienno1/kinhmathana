<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'shipping_provider', 'tracking_code', 'status', 'delivered_at'
    ];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
