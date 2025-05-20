<?php

namespace App\Services;

use App\Models\Promotion;
use App\Models\PromotionUsage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PromotionService
{
    /**
     * Check if promotion code is valid
     *
     * @param string $code
     * @param float $cartTotal
     * @param User $user
     * @return array
     */
    public function validatePromotionCode($code, $cartTotal, User $user)
    {
        $promotion = Promotion::where('code', $code)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
            
        if (!$promotion) {
            return [
                'valid' => false,
                'message' => 'Invalid or expired promotion code.'
            ];
        }
        
        // Check if minimum purchase requirement is met
        if ($cartTotal < $promotion->minimum_purchase) {
            return [
                'valid' => false,
                'message' => "Minimum purchase amount of " . number_format($promotion->minimum_purchase, 2) . " is required."
            ];
        }
        
        // Check usage limit
        if ($promotion->usage_limit !== null && $promotion->used_count >= $promotion->usage_limit) {
            return [
                'valid' => false,
                'message' => 'This promotion code has reached its usage limit.'
            ];
        }
        
        return [
            'valid' => true,
            'promotion' => $promotion,
            'discount_amount' => $this->calculateDiscount($promotion, $cartTotal)
        ];
    }
    
    /**
     * Calculate discount amount
     *
     * @param Promotion $promotion
     * @param float $cartTotal
     * @return float
     */
    public function calculateDiscount(Promotion $promotion, $cartTotal)
    {
        if ($promotion->discount_type === 'percentage') {
            $discount = ($cartTotal * $promotion->discount_value) / 100;
        } else {
            $discount = $promotion->discount_value;
        }
        
        // Discount cannot be greater than cart total
        return min($discount, $cartTotal);
    }
    
    /**
     * Apply promotion to an order
     *
     * @param Order $order
     * @param Promotion $promotion
     * @param User $user
     * @return void
     */
    public function applyPromotion(Order $order, Promotion $promotion, User $user)
    {
        $discountAmount = $this->calculateDiscount($promotion, $order->total_amount);
        
        // Update order with discount
        $order->update([
            'discount_amount' => $discountAmount,
            'final_amount' => $order->total_amount - $discountAmount
        ]);
        
        // Record promotion usage
        PromotionUsage::create([
            'promotion_id' => $promotion->id,
            'order_id' => $order->id,
            'user_id' => $user->id,
            'discount_amount' => $discountAmount
        ]);
        
        // Increment used count
        $promotion->increment('used_count');
    }
} 