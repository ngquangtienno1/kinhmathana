<?php

namespace App\Http\Controllers\Client;

use App\Models\News;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $news = News::with(['category', 'author'])
            ->active()
            ->published()
            ->orderByDesc('published_at')
            ->get();
        return view('client.blog.index', compact('news'));
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

        // Lấy bình luận đã duyệt cho bài viết này
        $comments = Comment::with(['user', 'replies.user'])
            ->where('entity_type', 'news')
            ->where('entity_id', $news->id)
            ->whereNull('parent_id')
            ->where('status', 'đã duyệt')
            ->orderByDesc('created_at')
            ->get();

        return view('client.blog.show', compact('news', 'mostViewed', 'comments'));
    }

    public function comment(Request $request, $slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'entity_type' => 'news',
            'entity_id' => $news->id,
            'content' => $request->content,
            'status' => 'chờ duyệt',
            'is_hidden' => false,
        ]);

        return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi và đang chờ duyệt!');
    }
}
