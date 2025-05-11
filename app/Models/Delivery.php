<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'address', 'phone_number', 'receiver_name',
        'note', 'expected_delivery_date'
    ];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
