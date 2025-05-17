<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'status_from',
        'status_to',
        'payment_status_from',
        'payment_status_to',
        'comment',
        'additional_data'
    ];

    protected $casts = [
        'additional_data' => 'json'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 