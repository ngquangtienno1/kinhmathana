<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingProvider;
use App\Models\ShippingFee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ShippingProviderController extends Controller
{
    public function index()
    {
        $providers = ShippingProvider::orderBy('sort_order')->get();
        return view('admin.settings.shipping.providers', compact('providers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shipping_providers,code',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'api_key' => 'nullable|string|max:255',
            'api_secret' => 'nullable|string|max:255',
            'api_endpoint' => 'nullable|string|max:255',
            'api_settings' => 'nullable|json',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Xử lý upload logo
        if ($request->hasFile('logo_url')) {
            $file = $request->file('logo_url');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/shipping', $fileName, 'public');
            $validated['logo_url'] = asset('storage/' . $filePath);
        }

        try {
            ShippingProvider::create($validated);
            return redirect()->back()->with('success', 'Thêm đơn vị vận chuyển thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(Request $request, ShippingProvider $provider)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shipping_providers,code,' . $provider->id,
            'description' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'api_key' => 'nullable|string|max:255',
            'api_secret' => 'nullable|string|max:255',
            'api_endpoint' => 'nullable|string|max:255',
            'api_settings' => 'nullable|json',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Xử lý upload logo mới
        if ($request->hasFile('logo_url')) {
            // Xóa logo cũ nếu có
            if ($provider->logo_url) {
                $oldPath = str_replace(asset('storage/'), '', $provider->logo_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Upload logo mới
            $file = $request->file('logo_url');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/shipping', $fileName, 'public');
            $validated['logo_url'] = asset('storage/' . $filePath);
        }

        try {
            $provider->update($validated);
            return redirect()->back()->with('success', 'Cập nhật đơn vị vận chuyển thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(ShippingProvider $provider)
    {
        // Xóa logo nếu có
        if ($provider->logo_url) {
            $path = str_replace(asset('storage/'), '', $provider->logo_url);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $provider->delete();
        return redirect()->back()->with('success', 'Xóa đơn vị vận chuyển thành công');
    }

    public function fees(ShippingProvider $provider)
    {
        $fees = $provider->shippingFees()->get();
        return view('admin.settings.shipping.fees', compact('provider', 'fees'));
    }

    public function storeFee(Request $request, ShippingProvider $provider)
    {
        $validated = $request->validate([
            'province_code' => 'required|string|max:10',
            'province_name' => 'required|string|max:125',
            'base_fee' => 'required|numeric|min:0',
            'weight_fee' => 'nullable|numeric|min:0',
            'distance_fee' => 'nullable|numeric|min:0',
            'extra_fees' => 'nullable|json',
            'note' => 'nullable|string'
        ]);

        $provider->shippingFees()->create($validated);
        return redirect()->back()->with('success', 'Thêm phí vận chuyển thành công');
    }

    public function updateFee(Request $request, ShippingProvider $provider, ShippingFee $fee)
    {
        $validated = $request->validate([
            'province_code' => 'required|string|max:10',
            'province_name' => 'required|string|max:125',
            'base_fee' => 'required|numeric|min:0',
            'weight_fee' => 'nullable|numeric|min:0',
            'distance_fee' => 'nullable|numeric|min:0',
            'extra_fees' => 'nullable|json',
            'note' => 'nullable|string'
        ]);

        $fee->update($validated);
        return redirect()->back()->with('success', 'Cập nhật phí vận chuyển thành công');
    }

    public function destroyFee(ShippingProvider $provider, ShippingFee $fee)
    {
        $fee->delete();
        return redirect()->back()->with('success', 'Xóa phí vận chuyển thành công');
    }

    public function updateStatus(Request $request, ShippingProvider $provider)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $provider->update($validated);
        return response()->json(['success' => true]);
    }
}
