<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'order_id', 'content', 'rating'];

    public $timestamps = ['created_at'];
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function canReview($userId, $productId, $orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->first();

        if (!$order) {
            return false;
        }

        // Kiểm tra xem người dùng đã đánh giá sản phẩm này trong đơn hàng chưa
        $existingReview = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('order_id', $orderId)
            ->exists();

        return !$existingReview;
    }
}
