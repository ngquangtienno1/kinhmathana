<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PaymentMethod::query();

        // Tìm kiếm theo tên hoặc mã
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sắp xếp
        $sort = $request->get('sort', 'sort_order');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        $paymentMethods = $query->get();
        $deletedCount = PaymentMethod::onlyTrashed()->count();
        $activeCount = PaymentMethod::where('is_active', true)->count();

        return view('admin.payment_methods.index', compact('paymentMethods', 'deletedCount', 'activeCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Vui lòng nhập tên phương thức thanh toán.',
            'name.max' => 'Tên phương thức thanh toán không được vượt quá 125 ký tự.',
            'name.unique' => 'Tên phương thức thanh toán đã tồn tại.',
            'code.required' => 'Vui lòng nhập mã phương thức thanh toán.',
            'code.max' => 'Mã phương thức thanh toán không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã phương thức thanh toán đã tồn tại.',
            'logo.image' => 'File phải là hình ảnh.',
            'logo.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'logo.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'sort_order.integer' => 'Thứ tự phải là số nguyên.',
            'sort_order.min' => 'Thứ tự không được nhỏ hơn 0.',
        ];

        $data = $request->validate([
            'name' => 'required|string|max:125|unique:payment_methods,name',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'api_key' => 'nullable|string|max:255',
            'api_secret' => 'nullable|string|max:255',
            'api_endpoint' => 'nullable|url|max:255',
            'api_settings' => 'nullable|json',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ], $messages);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $request->input('sort_order', 0);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('images/payment_methods', 'public');
        }

        PaymentMethod::create($data);
        return redirect()->route('admin.payment_methods.index')->with('success', 'Thêm phương thức thanh toán thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paymentMethod = PaymentMethod::withTrashed()->findOrFail($id);
        return view('admin.payment_methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        $messages = [
            'name.required' => 'Vui lòng nhập tên phương thức thanh toán.',
            'name.max' => 'Tên phương thức thanh toán không được vượt quá 125 ký tự.',
            'name.unique' => 'Tên phương thức thanh toán đã tồn tại.',
            'code.required' => 'Vui lòng nhập mã phương thức thanh toán.',
            'code.max' => 'Mã phương thức thanh toán không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã phương thức thanh toán đã tồn tại.',
            'logo.image' => 'File phải là hình ảnh.',
            'logo.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'logo.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'sort_order.integer' => 'Thứ tự phải là số nguyên.',
            'sort_order.min' => 'Thứ tự không được nhỏ hơn 0.',
        ];

        $data = $request->validate([
            'name' => 'required|string|max:125|unique:payment_methods,name,' . $paymentMethod->id . ',id,deleted_at,NULL',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $paymentMethod->id . ',id,deleted_at,NULL',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'api_key' => 'nullable|string|max:255',
            'api_secret' => 'nullable|string|max:255',
            'api_endpoint' => 'nullable|url|max:255',
            'api_settings' => 'nullable|json',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ], $messages);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $request->input('sort_order', $paymentMethod->sort_order);

        if ($request->hasFile('logo')) {
            $imgPath = $request->file('logo')->store('images/payment_methods', 'public');
            if ($paymentMethod->logo) {
                Storage::disk('public')->delete($paymentMethod->logo);
            }
            $data['logo'] = $imgPath;
        }

        $paymentMethod->update($data);
        return redirect()->route('admin.payment_methods.index')->with('success', 'Cập nhật phương thức thanh toán thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();
        return redirect()->route('admin.payment_methods.index')->with('success', 'Xóa phương thức thanh toán thành công!');
    }

    public function bin()
    {
        $paymentMethods = PaymentMethod::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('admin.payment_methods.bin', compact('paymentMethods'));
    }

    public function restore($id)
    {
        $paymentMethod = PaymentMethod::onlyTrashed()->findOrFail($id);
        $paymentMethod->restore();
        return redirect()->route('admin.payment_methods.bin')->with('success', 'Khôi phục phương thức thanh toán thành công!');
    }

    public function forceDelete($id)
    {
        $paymentMethod = PaymentMethod::withTrashed()->findOrFail($id);
        if ($paymentMethod->logo) {
            Storage::disk('public')->delete($paymentMethod->logo);
        }
        $paymentMethod->forceDelete();
        return redirect()->route('admin.payment_methods.bin')->with('success', 'Xóa vĩnh viễn phương thức thanh toán thành công!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một phương thức để xóa.');
        }
        PaymentMethod::whereIn('id', $ids)->delete();
        return redirect()->route('admin.payment_methods.index')->with('success', 'Đã xóa mềm các phương thức đã chọn!');
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một phương thức để khôi phục.');
        }
        PaymentMethod::onlyTrashed()->whereIn('id', $ids)->restore();
        return redirect()->route('admin.payment_methods.bin')->with('success', 'Đã khôi phục các phương thức đã chọn!');
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một phương thức để xóa vĩnh viễn.');
        }
        $methods = PaymentMethod::withTrashed()->whereIn('id', $ids)->get();
        foreach ($methods as $method) {
            if ($method->logo) {
                Storage::disk('public')->delete($method->logo);
            }
            $method->forceDelete();
        }
        return redirect()->route('admin.payment_methods.bin')->with('success', 'Đã xóa vĩnh viễn các phương thức đã chọn!');
    }
}
