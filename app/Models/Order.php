<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'discount_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'receiver_name',
        'receiver_phone',
        'receiver_email',
        'shipping_address',
        'total_amount',
        'subtotal',
        'discount_amount',
        'shipping_fee',
        'payment_method',
        'payment_details',
        'payment_status',
        'status',
        'note',
        'admin_note',
        'confirmed_at',
        'completed_at',
        'cancelled_at'
    ];

    protected $casts = [
        'payment_details' => 'json',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function histories()
    {
        return $this->hasMany(OrderHistory::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Chờ xử lý',
            'awaiting_payment' => 'Chờ thanh toán',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'returned' => 'Đã trả hàng',
            'processing_return' => 'Đang xử lý trả hàng',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định'
        };
    }

    public function getPaymentStatusLabelAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'refunded' => 'Đã hoàn tiền',
            'cancelled' => 'Đã huỷ',
            'partially_paid' => 'Thanh toán một phần',
            'disputed' => 'Đang tranh chấp',
            default => 'Không xác định'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'secondary',
            'awaiting_payment' => 'warning',
            'confirmed' => 'info',
            'processing' => 'primary',
            'shipping' => 'primary',
            'delivered' => 'success',
            'returned' => 'danger',
            'processing_return' => 'warning',
            'refunded' => 'info',
            default => 'secondary'
        };
    }

    public function getPaymentStatusColorAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info',
            'cancelled' => 'secondary',
            'partially_paid' => 'warning',
            'disputed' => 'danger',
            default => 'secondary'
        };
    }
}
