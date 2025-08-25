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
        $query = Category::query()->with(['parent'])->withCount('products');

        if ($request->filled('search')) {
            $search = mb_strtolower(trim($request->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"])
                    // Tìm kiếm theo tên danh mục cha
                    ->orWhereHas('parent', function ($subQ) use ($search) {
                        $subQ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    })
                    // Tìm kiếm theo tên danh mục con
                    ->orWhereHas('children', function ($subQ) use ($search) {
                        $subQ->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    });
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->addSelect('is_active');
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
        try {
            $messages = [
                'name.required' => 'Vui lòng nhập tên danh mục',
                'name.max' => 'Tên danh mục không được vượt quá 125 ký tự',
                'description.required' => 'Mô tả là bắt buộc',
                'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác'
            ];

            $dataNew = $request->validate([
                'name' => 'required|string|max:125',
                'description' => 'required|string',
                'slug' => 'nullable|string|unique:categories,slug',
                'is_active' => 'nullable|boolean'
            ], $messages);

            $dataNew['is_active'] = $request->boolean('is_active');

            // Nếu không có slug hoặc để trống, tự động tạo từ name
            if (empty($dataNew['slug'])) {
                $dataNew['slug'] = Str::slug($request->input('name'));
            }

            // Đảm bảo slug là duy nhất
            $slugCount = Category::where('slug', $dataNew['slug'])->count();
            if ($slugCount > 0) {
                $dataNew['slug'] = $dataNew['slug'] . '-' . ($slugCount + 1);
            }

            Category::create($dataNew);
            return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm danh mục: ' . $e->getMessage());
        }
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
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
            'name.max' => 'Tên danh mục không được vượt quá 125 ký tự.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
        ]);

        $category = Category::findOrFail($id);

        $data = $request->only(['name', 'description', 'slug', 'parent_id']);
        // Convert checkbox value to boolean
        $data['is_active'] = $request->has('is_active') && $request->input('is_active') == 1;

        // Xử lý parent_id - nếu để trống thì set null
        if (empty($data['parent_id'])) {
            $data['parent_id'] = null;
        }

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
            if (str_contains($e->getMessage(), 'Integrity constraint violation') && str_contains($e->getMessage(), 'foreign key constraint fails')) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa vĩnh viễn danh mục này vì nó đang được sử dụng bởi sản phẩm hoặc có dữ liệu liên quan khác. Vui lòng kiểm tra và xóa các dữ liệu liên quan trước.');
            }

            return redirect()->back()->with('error', 'Không thể xóa vĩnh viễn danh mục: ' . $e->getMessage());
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
            // Xử lý lỗi foreign key constraint
            if (str_contains($e->getMessage(), 'Integrity constraint violation') && str_contains($e->getMessage(), 'foreign key constraint fails')) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa vĩnh viễn một số danh mục vì chúng đang được sử dụng bởi sản phẩm hoặc có dữ liệu liên quan khác. Vui lòng kiểm tra và xóa các dữ liệu liên quan trước.');
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn: ' . $e->getMessage());
        }
    }
}
