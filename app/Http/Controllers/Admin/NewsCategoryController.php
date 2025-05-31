<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsCategory::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $categories = $query->get();
        $deletedCount = NewsCategory::onlyTrashed()->count();
        $activeCount = NewsCategory::where('is_active', true)->count();

        return view('admin.news.categories.index', compact('categories', 'deletedCount', 'activeCount'));
    }

    public function create()
    {
        return view('admin.news.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        NewsCategory::create($data);

        return redirect()->route('admin.news.categories.index')
            ->with('success', 'Danh mục tin tức đã được tạo thành công!');
    }

    public function edit(NewsCategory $category)
    {
        return view('admin.news.categories.edit', compact('category'));
    }

    public function update(Request $request, NewsCategory $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:news_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $category->update($data);

        return redirect()->route('admin.news.categories.index')
            ->with('success', 'Danh mục tin tức đã được cập nhật thành công!');
    }

    public function destroy(NewsCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.news.categories.index')
            ->with('success', 'Danh mục tin tức đã được xóa thành công!');
    }

    public function bin()
    {
        $categories = NewsCategory::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.news.categories.bin', compact('categories'));
    }

    public function restore($id)
    {
        $category = NewsCategory::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.news.categories.bin')
            ->with('success', 'Danh mục tin tức đã được khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $category = NewsCategory::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('admin.news.categories.bin')
            ->with('success', 'Danh mục tin tức đã được xóa vĩnh viễn!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = explode(',', $request->ids);
        NewsCategory::whereIn('id', $ids)->delete();

        return redirect()->route('admin.news.categories.index')
            ->with('success', 'Các danh mục đã được xóa thành công!');
    }

    public function bulkRestore(Request $request)
    {
        $ids = explode(',', $request->ids);
        NewsCategory::onlyTrashed()->whereIn('id', $ids)->restore();

        return redirect()->route('admin.news.categories.bin')
            ->with('success', 'Các danh mục đã được khôi phục thành công!');
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        NewsCategory::withTrashed()->whereIn('id', $ids)->forceDelete();

        return redirect()->route('admin.news.categories.bin')
            ->with('success', 'Các danh mục đã được xóa vĩnh viễn!');
    }
}
