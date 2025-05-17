<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'transaction_code',
        'payment_method_id'
    ];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function getFormattedPaymentDateAttribute()
    {
        return \Carbon\Carbon::parse($this->payment_date)->format('d M, Y');
    }
}
