<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->withCount('products');

        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
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

        $categories = $query->get();
        $activeCount = Category::where('is_active', true)->count();
        $deletedCount = Category::onlyTrashed()->count();

        return view('admin.categories.index', compact('categories', 'activeCount', 'deletedCount'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:125',
            'description' => 'required|string',
            'slug' => 'nullable|string|unique:categories,slug',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
            'name.max' => 'Tên danh mục không được vượt quá 125 ký tự.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
        ]);

        $data = $request->all();
        // Nếu không có slug hoặc để trống, tự động tạo từ name
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->input('name'));
        }

        // Đảm bảo slug là duy nhất
        $slugCount = Category::where('slug', $data['slug'])->count();
        if ($slugCount > 0) {
            $data['slug'] = $data['slug'] . '-' . ($slugCount + 1);
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:125',
            'description' => 'required|string',
            'slug' => 'nullable|string|unique:categories,slug,' . $id,
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
            'name.max' => 'Tên danh mục không được vượt quá 125 ký tự.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
        ]);

        $category = Category::findOrFail($id);

        $data = $request->all();
        // Convert checkbox value to boolean
        $data['is_active'] = $request->has('is_active');

        if (empty($data['slug']) || $category->name !== $request->input('name')) {
            $data['slug'] = Str::slug($request->input('name'));

            $slugCount = Category::where('slug', $data['slug'])->where('id', '!=', $id)->count();
            if ($slugCount > 0) {
                $data['slug'] = $data['slug'] . '-' . ($slugCount + 1);
            }
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa mềm danh mục thành công!');
    }

    public function bin()
    {
        $categories = Category::onlyTrashed()->orderBy('id', 'desc')->get();
        return view('admin.categories.bin', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.bin')->with('success', 'Khôi phục danh mục thành công!');
    }

    public function forceDelete($id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->forceDelete();
            return redirect()->route('admin.categories.bin')->with('success', 'Xóa vĩnh viễn danh mục thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể xóa vĩnh viễn danh mục.');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục để xóa.');
        }
        try {
            Category::whereIn('id', $ids)->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Đã xóa mềm các danh mục đã chọn!');
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
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục để khôi phục.');
        }
        try {
            Category::onlyTrashed()->whereIn('id', $ids)->restore();
            return redirect()->route('admin.categories.bin')->with('success', 'Đã khôi phục các danh mục đã chọn!');
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
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một danh mục để xóa vĩnh viễn.');
        }
        try {
            Category::withTrashed()->whereIn('id', $ids)->forceDelete();
            return redirect()->route('admin.categories.bin')->with('success', 'Đã xóa vĩnh viễn các danh mục đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn: ' . $e->getMessage());
        }
    }
}
