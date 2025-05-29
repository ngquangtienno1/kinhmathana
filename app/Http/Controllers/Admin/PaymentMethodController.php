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
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);
        $paymentMethods = $query->orderBy('id', 'desc')->get();
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
            'name.max' => 'Tên phương thức thanh toán không được vượt quá 50 ký tự.',
            'name.unique' => 'Tên phương thức thanh toán đã tồn tại.',
            'logo_url.image' => 'File phải là hình ảnh.',
            'logo_url.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'logo_url.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:payment_methods,name',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ], $messages);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo_url')) {
            $data['logo_url'] = $request->file('logo_url')->store('images/payment_methods', 'public');
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
            'name.max' => 'Tên phương thức thanh toán không được vượt quá 50 ký tự.',
            'name.unique' => 'Tên phương thức thanh toán đã tồn tại.',
            'logo_url.image' => 'File phải là hình ảnh.',
            'logo_url.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'logo_url.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:payment_methods,name,' . $paymentMethod->id . ',id,deleted_at,NULL',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
        ], $messages);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo_url')) {
            $imgPath = $request->file('logo_url')->store('images/payment_methods', 'public');
            if ($paymentMethod->logo_url) {
                Storage::disk('public')->delete($paymentMethod->logo_url);
            }
            $data['logo_url'] = $imgPath;
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
        if ($paymentMethod->logo_url) {
            Storage::disk('public')->delete($paymentMethod->logo_url);
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
            if ($method->logo_url) {
                Storage::disk('public')->delete($method->logo_url);
            }
            $method->forceDelete();
        }
        return redirect()->route('admin.payment_methods.bin')->with('success', 'Đã xóa vĩnh viễn các phương thức đã chọn!');
    }
}