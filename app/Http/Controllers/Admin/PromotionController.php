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
        ]);

        // Create promotion
        $promotion = Promotion::create($validated);

        // Attach products if any
        if (isset($validated['products'])) {
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

        // Sync products
        if (isset($validated['products'])) {
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
