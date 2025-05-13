<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Services\PromotionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    /**
     * Validate a promotion code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'cart_total' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $result = $this->promotionService->validatePromotionCode(
            $request->code,
            $request->cart_total,
            $user
        );

        if (!$result['valid']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'promotion' => [
                    'id' => $result['promotion']->id,
                    'name' => $result['promotion']->name,
                    'code' => $result['promotion']->code,
                    'discount_type' => $result['promotion']->discount_type,
                    'discount_value' => $result['promotion']->discount_value,
                ],
                'discount_amount' => $result['discount_amount'],
                'final_amount' => $request->cart_total - $result['discount_amount']
            ]
        ]);
    }

    /**
     * Get available promotions for the customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAvailablePromotions()
    {
        $promotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereRaw('(usage_limit IS NULL OR used_count < usage_limit)')
            ->select('id', 'name', 'code', 'description', 'discount_type', 'discount_value', 'minimum_purchase')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $promotions
        ]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu...

        $promotion = new Promotion();
        $promotion->name = $request->name;
        $promotion->code = $request->code;
        // ... các trường khác ...
        $promotion->is_active = $request->has('is_active') ? $request->is_active : 1; // Mặc định là 1 (active)
        $promotion->save();

        // ...
    }

    public function update(Request $request, $id)
    {
        // Validate dữ liệu...

        $promotion = Promotion::findOrFail($id);
        $promotion->name = $request->name;
        // ... các trường khác ...
        $promotion->is_active = $request->has('is_active') ? $request->is_active : 1;
        $promotion->save();

        // ...
    }
} 