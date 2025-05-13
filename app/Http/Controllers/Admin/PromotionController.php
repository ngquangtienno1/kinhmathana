<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PromotionController extends Controller
{
    /**
     * Display a listing of promotions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new promotion.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status', 'active')->get();
        return view('admin.promotions.create', compact('products'));
    }

    /**
     * Store a newly created promotion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        ];
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:promotions',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_purchase' => 'required|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ], $messages);

        // Create promotion
        $promotion = Promotion::create($validated);

        // Attach products if any
        if (!empty($validated['products'])) {
            $promotion->products()->attach($validated['products']);
        }

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion created successfully.');
    }

    /**
     * Display the specified promotion.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        $promotion->load('products', 'usages.order', 'usages.user');
        return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified promotion.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        $products = Product::where('status', 'active')->get();
        $selectedProducts = $promotion->products->pluck('id')->toArray();
        
        return view('admin.promotions.edit', compact('promotion', 'products', 'selectedProducts'));
    }

    /**
     * Update the specified promotion in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
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
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        // Update promotion
        $promotion->update($validated);

        // Sync products if any
        if (!empty($validated['products'])) {
            $promotion->products()->sync($validated['products']);
        } else {
            $promotion->products()->detach();
        }

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion updated successfully.');
    }

    /**
     * Remove the specified promotion from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        // Check if the promotion has been used
        if ($promotion->used_count > 0) {
            return redirect()->route('admin.promotions.index')
                ->with('error', 'Cannot delete promotion that has been used.');
        }
        
        $promotion->products()->detach();
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion deleted successfully.');
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
} 
