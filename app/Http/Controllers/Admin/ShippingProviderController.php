<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingProvider;
use App\Models\ShippingFee;

class ShippingProviderController extends Controller
{
    public function index()
    {
        $providers = ShippingProvider::orderBy('sort_order')->get();
        return view('admin.settings.shipping.providers', compact('providers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:125',
            'code' => 'required|string|max:50|unique:shipping_providers',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string|max:255',
            'api_key' => 'nullable|string|max:255',
            'api_secret' => 'nullable|string|max:255',
            'api_endpoint' => 'nullable|string|max:255',
            'api_settings' => 'nullable|json',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        ShippingProvider::create($validated);
        return redirect()->back()->with('success', 'Thêm đơn vị vận chuyển thành công');
    }

    public function update(Request $request, ShippingProvider $provider)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:125',
            'code' => 'required|string|max:50|unique:shipping_providers,code,' . $provider->id,
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string|max:255',
            'api_key' => 'nullable|string|max:255',
            'api_secret' => 'nullable|string|max:255',
            'api_endpoint' => 'nullable|string|max:255',
            'api_settings' => 'nullable|json',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $provider->update($validated);
        return redirect()->back()->with('success', 'Cập nhật đơn vị vận chuyển thành công');
    }

    public function destroy(ShippingProvider $provider)
    {
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
}
