<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();

        // Tìm kiếm theo tên hoặc mô tả
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
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

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $brands = $query->get();
        $deletedCount = Brand::onlyTrashed()->count();
        $activeCount = Brand::where('is_active', true)->count();

        return view('admin.brands.index', compact('brands', 'deletedCount', 'activeCount'));
    }

    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.show', compact('brand'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        try {
            $messages = [
                'name.required' => 'Vui lòng nhập tên thương hiệu',
                'name.max' => 'Tên thương hiệu không được vượt quá 125 ký tự',
                'image.required' => 'Vui lòng chọn hình ảnh',
                'image.image' => 'File phải là hình ảnh',
                'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif'
            ];

            $dataNew = $request->validate([
                'name' => 'required|string|max:125',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'is_active' => 'nullable|boolean'
            ], $messages);

            $dataNew['is_active'] = $request->boolean('is_active');

            // Lưu ảnh
            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('images/brands', 'public');
                $dataNew['image'] = $imgPath;
            }

            Brand::create($dataNew);
            return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm thương hiệu: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        try {
            $brand = Brand::findOrFail($id);

            $messages = [
                'name.required' => 'Vui lòng nhập tên thương hiệu',
                'name.max' => 'Tên thương hiệu không được vượt quá 125 ký tự',
                'image.image' => 'File phải là hình ảnh',
                'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif'
            ];

            $dataNew = $request->validate([
                'name' => 'required|string|max:125',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'is_active' => 'nullable|boolean'
            ], $messages);

            $dataNew['is_active'] = $request->boolean('is_active');

            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('images/brands', 'public');

                // Xóa ảnh cũ nếu có
                if ($brand->image) {
                    Storage::disk('public')->delete($brand->image);
                }

                $dataNew['image'] = $imgPath;
            }

            $brand->update($dataNew);
            return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật thương hiệu: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete(); // Soft delete
            return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa thương hiệu: ' . $e->getMessage());
        }
    }

    public function bin()
    {
        $brands = Brand::onlyTrashed()->orderBy('deleted_at', 'asc')->get();
        return view('admin.brands.bin', compact('brands'));
    }

    public function restore($id)
    {
        try {
            $brand = Brand::onlyTrashed()->findOrFail($id);
            $brand->restore();
            return redirect()->route('admin.brands.bin')->with('success', 'Khôi phục thương hiệu thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi khôi phục thương hiệu: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $brand = Brand::withTrashed()->findOrFail($id);

            // Xóa ảnh nếu có
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $brand->forceDelete();
            return redirect()->route('admin.brands.bin')->with('success', 'Xóa vĩnh viễn thương hiệu thành công!');
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'Integrity constraint violation') && str_contains($e->getMessage(), 'foreign key constraint fails')) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa vĩnh viễn thương hiệu này vì nó đang được sử dụng bởi sản phẩm hoặc có dữ liệu liên quan khác. Vui lòng kiểm tra và xóa các dữ liệu liên quan trước.');
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn thương hiệu: ' . $e->getMessage());
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một thương hiệu để xóa.');
        }
        try {
            Brand::whereIn('id', $ids)->delete();
            return redirect()->route('admin.brands.index')->with('success', 'Đã xóa mềm các thương hiệu đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa: ' . $e->getMessage());
        }
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một thương hiệu để khôi phục.');
        }
        try {
            Brand::onlyTrashed()->whereIn('id', $ids)->restore();
            return redirect()->route('admin.brands.bin')->with('success', 'Đã khôi phục các thương hiệu đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi khôi phục: ' . $e->getMessage());
        }
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một thương hiệu để xóa vĩnh viễn.');
        }
        try {
            $brands = Brand::withTrashed()->whereIn('id', $ids)->get();
            foreach ($brands as $brand) {
                if ($brand->image) {
                    Storage::disk('public')->delete($brand->image);
                }
                $brand->forceDelete();
            }
            return redirect()->route('admin.brands.bin')->with('success', 'Đã xóa vĩnh viễn các thương hiệu đã chọn!');
        } catch (\Exception $e) {
            // Xử lý lỗi foreign key constraint
            if (str_contains($e->getMessage(), 'Integrity constraint violation') && str_contains($e->getMessage(), 'foreign key constraint fails')) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa vĩnh viễn một số thương hiệu vì chúng đang được sử dụng bởi sản phẩm hoặc có dữ liệu liên quan khác. Vui lòng kiểm tra và xóa các dữ liệu liên quan trước.');
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn: ' . $e->getMessage());
        }
    }
}