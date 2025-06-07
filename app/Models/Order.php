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
        'promotion_id',
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
        'promotion_amount',
        'shipping_fee',
        'payment_method',
        'payment_details',
        'payment_status',
        'status',
        'note',
        'admin_note',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
        'cancellation_reason_id',
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

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
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

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function shippingProvider()
    {
        return $this->belongsTo(ShippingProvider::class);
    }

    public function cancellationReason()
    {
        return $this->belongsTo(\App\Models\CancellationReason::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }


    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'awaiting_pickup' => 'Chờ lấy hàng',
            'shipping' => 'Đang giao',
            'delivered' => 'Đã giao hàng',
            'completed' => 'Đã hoàn thành',
            'cancelled_by_customer' => 'Khách hủy đơn',
            'cancelled_by_admin' => 'Admin hủy đơn',
            'delivery_failed' => 'Giao thất bại',
            'returned_requested' => 'Khách trả hàng',
            'processing_return' => 'Đang xử lý trả hàng',
            'return_rejected' => 'Trả hàng bị từ chối',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định',
        };
    }

    public function getPaymentStatusLabelAttribute()
    {
        return match ($this->payment_status) {
            'unpaid' => 'Chờ thanh toán',
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
        return match ($this->status) {
            'pending' => 'secondary',
            'confirmed' => 'info',
            'awaiting_pickup' => 'primary',
            'shipping' => 'warning',
            'delivered' => 'success',
            'completed' => 'success',
            'cancelled_by_customer' => 'danger',
            'cancelled_by_admin' => 'danger',
            'delivery_failed' => 'danger',
            'returned_requested' => 'warning',
            'processing_return' => 'warning',
            'return_rejected' => 'danger',
            'refunded' => 'info',
            default => 'secondary',
        };
    }

    public function getPaymentStatusColorAttribute()
    {
        return match ($this->payment_status) {
            'unpaid' => 'warning',
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
