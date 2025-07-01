<?php

namespace App\Http\Controllers\Client;

use App\Models\News;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $newsQuery = News::with(['category', 'author'])
            ->active()
            ->published();
        if ($query) {
            $newsQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                    ->orWhere('summary', 'like', "%$query%");
            });
        }
        $news = $newsQuery->orderByDesc('published_at')->paginate(5)->withQueryString();
        $categories = NewsCategory::where('is_active', true)
            ->withCount(['news' => function ($q) {
                $q->active()->published();
            }])
            ->orderBy('name')
            ->get();
        $latestNews = News::with(['category', 'author'])
            ->active()
            ->published()
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();
        return view('client.blog.index', compact('news', 'categories', 'latestNews', 'query'));
    }

    public function show($slug)
    {
        $news = News::with(['category', 'author'])
            ->active()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();
        // Tăng lượt xem
        $news->increment('views');

        // Lấy 6 bài viết xem nhiều nhất (trừ bài hiện tại)
        $mostViewed = News::active()->published()->where('id', '!=', $news->id)->orderByDesc('views')->limit(6)->get();

        // Lấy 1 bài viết cùng danh mục (trừ bài hiện tại)
        $relatedNews = News::active()
            ->published()
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->orderByDesc('published_at')
            ->first();

        // Lấy bình luận đã duyệt cho bài viết này
        $comments = Comment::with(['user', 'replies.user'])
            ->where('entity_type', 'news')
            ->where('entity_id', $news->id)
            ->whereNull('parent_id')
            ->where('status', 'đã duyệt')
            ->orderByDesc('created_at')
            ->get();

        return view('client.blog.show', compact('news', 'mostViewed', 'comments', 'relatedNews'));
    }

    public function comment(Request $request, $slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        if (!auth()->check()) {
            return redirect()->back()->withErrors(['Bạn cần đăng nhập để bình luận.']);
        }

        Comment::create([
            'user_id' => auth()->id(),
            'entity_type' => 'news',
            'entity_id' => $news->id,
            'content' => $request->content,
            'status' => 'chờ duyệt',
            'is_hidden' => false,
            'parent_id' => null,
        ]);

        return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi và đang chờ duyệt!');
    }
}