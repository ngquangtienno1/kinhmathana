<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\Category;
use App\Models\PromotionUsage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    /**
     * Display a listing of promotions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Promotion::query();

        // Tìm kiếm theo tên hoặc mã
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by discount type
        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $promotions = $query->get();
        $activeCount = Promotion::where('is_active', true)->count();
        $inactiveCount = Promotion::where('is_active', false)->count();
        $percentageCount = Promotion::where('discount_type', 'percentage')->count();
        $fixedCount = Promotion::where('discount_type', 'fixed')->count();

        return view('admin.promotions.index', compact('promotions', 'activeCount', 'inactiveCount', 'percentageCount', 'fixedCount'));
    }

    /**
     * Show the form for creating a new promotion.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $products = Product::where('status', 'active')->get();
            $categories = Category::all();
            $promotions = Promotion::where('is_active', true)->get();

            return view('admin.promotions.create', compact('products', 'categories', 'promotions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created promotion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $messages = [
                'name.required' => 'Tên khuyến mãi không được để trống.',
                'name.max' => 'Tên khuyến mãi không được vượt quá 255 ký tự.',
                'code.required' => 'Mã khuyến mãi không được để trống.',
                'code.unique' => 'Mã khuyến mãi đã tồn tại.',
                'code.max' => 'Mã khuyến mãi không được vượt quá 50 ký tự.',
                'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
                'discount_type.in' => 'Loại giảm giá không hợp lệ.',
                'discount_value.required' => 'Vui lòng nhập giá trị giảm.',
                'discount_value.numeric' => 'Giá trị giảm phải là số.',
                'discount_value.min' => 'Giá trị giảm phải lớn hơn hoặc bằng 0.',
                'minimum_purchase.required' => 'Vui lòng nhập giá trị đơn tối thiểu.',
                'minimum_purchase.numeric' => 'Giá trị đơn tối thiểu phải là số.',
                'minimum_purchase.min' => 'Giá trị đơn tối thiểu phải lớn hơn hoặc bằng 0.',
                'maximum_purchase.min' => 'Giá trị đơn tối thiểu phải lớn hơn hoặc bằng 0.',
                'maximum_purchase.gt' => 'Giá trị đơn tối thiểu phải lớn hơn giá trị đơn tối thiểu.',
                'usage_limit.integer' => 'Giới hạn lượt dùng phải là số nguyên.',
                'usage_limit.min' => 'Giới hạn lượt dùng phải lớn hơn 0.',
                'is_active.boolean' => 'Trạng thái không hợp lệ.',
                'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
                'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
                'end_date.date' => 'Ngày kết thúc không hợp lệ.',
                'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
                'products.array' => 'Danh sách sản phẩm không hợp lệ.',
                'products.*.exists' => 'Sản phẩm được chọn không tồn tại.',
                'categories.array' => 'Danh sách danh mục không hợp lệ.',
                'categories.*.exists' => 'Danh mục được chọn không tồn tại.',
            ];

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:promotions',
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'minimum_purchase' => 'required|numeric|min:0',
                'maximum_purchase' => 'nullable|numeric|min:0|gt:minimum_purchase',
                'usage_limit' => 'nullable|integer|min:1',
                'is_active' => 'boolean',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'products' => 'nullable|array',
                'products.*' => 'exists:products,id',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
            ], $messages);

            // Create promotion
            $promotion = Promotion::create($validated);

            // Attach products if any
            if (!empty($validated['products'])) {
                $promotion->products()->attach($validated['products']);
            }

            // Attach categories if any
            if (!empty($validated['categories'])) {
                $promotion->categories()->attach($validated['categories']);
            }

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Khuyến mãi đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo khuyến mãi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified promotion.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotion = Promotion::with(['products', 'categories', 'usages.order', 'usages.user'])->findOrFail($id);
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified promotion.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
            $products = Product::where('status', 'active')->get();
            $categories = Category::all();
            $selectedProducts = $promotion->products->pluck('id')->toArray();
            $selectedCategories = $promotion->categories->pluck('id')->toArray();

            return view('admin.promotions.edit', compact('promotion', 'products', 'categories', 'selectedProducts', 'selectedCategories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified promotion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $promotion = Promotion::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('promotions')->ignore($promotion->id),
                ],
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'minimum_purchase' => 'required|numeric|min:0',
                'maximum_purchase' => 'nullable|numeric|min:0|gt:minimum_purchase',
                'usage_limit' => 'nullable|integer|min:1',
                'is_active' => 'boolean',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'products' => 'nullable|array',
                'products.*' => 'exists:products,id',
                'categories' => 'nullable|array',
                'categories.*' => 'exists:categories,id',
            ]);

            // Update promotion
            $promotion->update($validated);

            // Sync products if any
            if (!empty($validated['products'])) {
                $promotion->products()->sync($validated['products']);
            } else {
                $promotion->products()->detach();
            }

            // Sync categories if any
            if (!empty($validated['categories'])) {
                $promotion->categories()->sync($validated['categories']);
            } else {
                $promotion->categories()->detach();
            }

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Khuyến mãi đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật khuyến mãi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified promotion from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $promotion = Promotion::findOrFail($id);

            // Check if the promotion has been used
            if ($promotion->used_count > 0) {
                return redirect()->route('admin.promotions.index')
                    ->with('error', 'Không thể xóa khuyến mãi đã được sử dụng.');
            }

            $promotion->products()->detach();
            $promotion->categories()->detach();
            $promotion->delete();

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Khuyến mãi đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa khuyến mãi: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete promotions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        try {
            $ids = explode(',', $request->ids);

            // Check if any of the promotions have been used
            $usedPromotions = Promotion::whereIn('id', $ids)
                ->where('used_count', '>', 0)
                ->get();

            if ($usedPromotions->isNotEmpty()) {
                return redirect()->route('admin.promotions.index')
                    ->with('error', 'Không thể xóa các khuyến mãi đã được sử dụng.');
            }

            // Delete promotions
            foreach ($ids as $id) {
                $promotion = Promotion::find($id);
                if ($promotion) {
                    $promotion->products()->detach();
                    $promotion->categories()->detach();
                    $promotion->delete();
                }
            }

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Các khuyến mãi đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa khuyến mãi: ' . $e->getMessage());
        }
    }

    /**
     * Generate a unique code for promotion.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateCode()
    {
        $code = strtoupper(Str::random(8));

        // Ensure code is unique
        while (Promotion::where('code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }

        return response()->json(['code' => $code]);
    }

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
                'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.'
            ];
        }

        // Check if minimum purchase requirement is met
        if ($cartTotal < $promotion->minimum_purchase) {
            return [
                'valid' => false,
                'message' => "Yêu cầu giá trị đơn hàng tối thiểu là " . number_format($promotion->minimum_purchase, 0, ',', '.') . "đ."
            ];
        }

        // Check usage limit
        if ($promotion->usage_limit !== null && $promotion->used_count >= $promotion->usage_limit) {
            return [
                'valid' => false,
                'message' => 'Mã khuyến mãi này đã đạt đến giới hạn sử dụng.'
            ];
        }

        return [
            'valid' => true,
            'promotion' => $promotion,
            'discount_amount' => $this->calculateDiscount($promotion, $cartTotal)
        ];
    }

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