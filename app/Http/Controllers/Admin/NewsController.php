<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['category', 'author']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('author')) {
            $query->where('author_id', $request->author);
        }

        // Lọc theo ngày tạo
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Sắp xếp theo lượt xem nếu được yêu cầu
        if ($request->filled('sort_by') && $request->sort_by === 'views') {
            $query->orderBy('views', $request->sort_order ?? 'desc');
        } else {
            $query->latest();
        }

        $news = $query->get();
        $categories = NewsCategory::where('is_active', true)->get();
        $deletedCount = News::onlyTrashed()->count();
        $activeCount = News::where('is_active', true)->count();

        // Lấy top 5 bài viết có lượt xem nhiều nhất
        $mostViewedNews = News::with(['category', 'author'])
            ->active()
            ->published()
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('admin.news.index', compact('news', 'categories', 'deletedCount', 'activeCount', 'mostViewedNews'));
    }

    public function show(News $news)
    {
        // Tăng lượt xem
        $news->increment('views');
        $news->refresh(); // Refresh để lấy giá trị views mới nhất
        
        $news->load(['category', 'author']);
        
        // Lấy các bài viết liên quan cùng danh mục
        $relatedNews = News::with(['category', 'author'])
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->active()
            ->published()
            ->latest()
            ->limit(3)
            ->get();

        return view('admin.news.show', compact('news', 'relatedNews'));
    }

    public function create()
    {
        $categories = NewsCategory::where('is_active', true)->get();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:news_categories,id',
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['author_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được tạo thành công!');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::where('is_active', true)->get();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:news_categories,id',
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được cập nhật thành công!');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return redirect()->route('admin.news.index')
            ->with('success', 'Tin tức đã được xóa thành công!');
    }

    public function bin()
    {
        $news = News::onlyTrashed()->with(['category', 'author'])->latest()->get();
        return view('admin.news.bin', compact('news'));
    }

    public function restore($id)
    {
        $news = News::onlyTrashed()->findOrFail($id);
        $news->restore();
        return redirect()->route('admin.news.bin')
            ->with('success', 'Tin tức đã được khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $news = News::withTrashed()->findOrFail($id);
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->forceDelete();
        return redirect()->route('admin.news.bin')
            ->with('success', 'Tin tức đã được xóa vĩnh viễn!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = explode(',', $request->ids);
        $news = News::whereIn('id', $ids)->get();

        foreach ($news as $item) {
            // Không xóa ảnh khi xóa mềm
            $item->delete();
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Các tin tức đã được xóa thành công!');
    }

    public function bulkRestore(Request $request)
    {
        $ids = explode(',', $request->ids);
        News::onlyTrashed()->whereIn('id', $ids)->restore();

        return redirect()->route('admin.news.bin')
            ->with('success', 'Các tin tức đã được khôi phục thành công!');
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $news = News::withTrashed()->whereIn('id', $ids)->get();

        foreach ($news as $item) {
            // Chỉ xóa ảnh khi xóa vĩnh viễn
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $item->forceDelete();
        }

        return redirect()->route('admin.news.bin')
            ->with('success', 'Các tin tức đã được xóa vĩnh viễn!');
    }
}
