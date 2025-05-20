<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();

        // Tìm kiếm theo tiêu đề hoặc nội dung
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
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

        $news = $query->get();
        $deletedCount = News::onlyTrashed()->count();
        $activeCount = News::where('is_active', true)->count();

        return view('admin.news.index', compact('news', 'deletedCount', 'activeCount'));
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        try {
            $dataNew = $request->validate([
                'title' => 'required|string|max:125',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'required|boolean',
                'slug' => 'nullable|string|max:125|unique:news,slug'
            ]);

            // Tạo slug từ tiêu đề nếu không có slug được nhập
            if (empty($request->slug)) {
                $dataNew['slug'] = Str::slug($dataNew['title']);
            } else {
                $dataNew['slug'] = Str::slug($request->slug);
            }

            // Lưu ảnh
            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('images/news', 'public');
                $dataNew['image'] = $imgPath;
            }

            News::create($dataNew);
            return redirect()->route('admin.news.index')->with('success', 'Thêm tin tức thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm tin tức: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        try {
            $news = News::findOrFail($id);

            $dataNew = $request->validate([
                'title' => 'required|string|max:125',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'required|boolean'
            ]);

            // Tạo slug từ tiêu đề
            $dataNew['slug'] = Str::slug($dataNew['title']);

            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('images/news', 'public');

                // Xóa ảnh cũ nếu có
                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                }

                $dataNew['image'] = $imgPath;
            }

            $news->update($dataNew);
            return redirect()->route('admin.news.index')->with('success', 'Cập nhật tin tức thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật tin tức: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $news = News::findOrFail($id);
            $news->delete(); // Soft delete
            return redirect()->route('admin.news.index')->with('error', 'Xóa tin tức thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa tin tức: ' . $e->getMessage());
        }
    }

    public function bin()
    {
        $news = News::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('admin.news.bin', compact('news'));
    }

    public function restore($id)
    {
        try {
            $news = News::onlyTrashed()->findOrFail($id);
            $news->restore();
            return redirect()->route('admin.news.bin')->with('success', 'Khôi phục tin tức thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi khôi phục tin tức: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $news = News::withTrashed()->findOrFail($id);

            // Xóa ảnh nếu có
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $news->forceDelete();
            return redirect()->route('admin.news.bin')->with('error', 'Xóa vĩnh viễn tin tức thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn tin tức: ' . $e->getMessage());
        }
    }
}
