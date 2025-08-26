<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'discount_type',
        'discount_value',
        'minimum_purchase',
        'maximum_purchase',
        'usage_limit',
        'used_count',
        'is_active',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'discount_value' => 'decimal:2',
        'minimum_purchase' => 'decimal:2',
        'maximum_purchase' => 'decimal:2',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_products');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'promotion_categories');
    }

    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }

    public function isValid()
    {
        $now = now();
        $today = now()->startOfDay();
        $tomorrow = now()->addDay()->startOfDay();
        return $this->is_active &&
            $tomorrow->greaterThanOrEqualTo($this->start_date) &&
            $today->lessThanOrEqualTo($this->end_date) &&
            ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    /**
     * Kiểm tra xem sản phẩm có thuộc danh mục được áp dụng mã giảm giá không
     */
    public function isProductEligible(Product $product)
    {
        // Nếu không có danh mục nào được chọn, áp dụng cho tất cả sản phẩm
        if ($this->categories->isEmpty()) {
            return true;
        }

        // Kiểm tra xem sản phẩm có thuộc bất kỳ danh mục nào được chọn không
        return $this->categories->contains($product->category_id);
    }

    /**
     * Kiểm tra xem đơn hàng có đủ điều kiện để áp dụng mã giảm giá không
     */
    public function isOrderEligible($totalAmount)
    {
        return $totalAmount >= $this->minimum_purchase;
    }
}
