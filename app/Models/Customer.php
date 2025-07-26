<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'default_address',
        'customer_type',
        'total_orders',
        'total_spent',
        'last_order_at'
    ];

    protected $casts = [
        'last_order_at' => 'datetime',
        'total_spent' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    public function updateCustomerType()
    {
        if (
            $this->total_spent >= 5000000
            || $this->total_orders >= 10
        ) {
            $this->customer_type = 'vip';
        } elseif ($this->created_at->diffInDays(now()) <= 7) {
            $this->customer_type = 'new';
        } elseif ($this->total_orders == 0) {
            $this->customer_type = 'potential';
        } else {
            $this->customer_type = 'regular';
        }
    }

    public function getCalculatedTotalSpentAttribute()
    {
        return $this->orders->sum(function ($order) {
            $calculatedSubtotal = $order->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            return $calculatedSubtotal - ($order->promotion_amount ?? 0) + ($order->shipping_fee ?? 0);
        });
    }
}