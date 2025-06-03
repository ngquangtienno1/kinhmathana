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
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
        }

        // Ưu tiên danh mục cha (parent_id là null), sau đó sắp xếp theo created_at giảm dần
        $query->orderByRaw('parent_id IS NULL DESC')
              ->orderBy('parent_id', 'asc')
              ->orderBy('created_at', 'desc');

        $categories = $query->paginate(10);
        $activeCount = Category::count();
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
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
            'name.max' => 'Tên danh mục không được vượt quá 125 ký tự.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
        ]);

        $category = Category::findOrFail($id);

        $data = $request->all();
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
        $categories = Category::onlyTrashed()->orderBy('id', 'desc')->paginate(10);
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
}
