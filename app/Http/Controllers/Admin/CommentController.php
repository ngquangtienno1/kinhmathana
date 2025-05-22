<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\News;
use App\Models\Product;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::query();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                // Assuming 'active' means 'đã duyệt' for now, based on previous context.
                // We'll adjust the view to use specific statuses.
                $query->where('status', 'đã duyệt');
            } elseif ($request->status === 'trashed') {
                $query->onlyTrashed();
            } else {
                // Filter by specific status
                $query->where('status', $request->status);
            }
        }

        // Tìm kiếm theo nội dung, entity_id hoặc thông tin người dùng
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(content) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                            ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%']);
                    });
            });
        }

        $comments = $query->get();

        $totalCount = Comment::count();
        $approvedCount = Comment::where('status', 'đã duyệt')->count();
        $pendingCount = Comment::where('status', 'chờ duyệt')->count();
        $spamCount = Comment::where('status', 'spam')->count();
        $blockedCount = Comment::where('status', 'chặn')->count();
        $deletedCount = Comment::onlyTrashed()->count();

        // Lấy danh sách bài viết và sản phẩm cho filter
        $news = News::pluck('title', 'id');
        $products = Product::pluck('name', 'id');

        return view('admin.comments.index', compact('comments', 'totalCount', 'approvedCount', 'pendingCount', 'spamCount', 'blockedCount', 'deletedCount', 'news', 'products'));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $request->validate([

            'is_hidden' => 'required|boolean',
        ]);

        $comment->is_hidden = $request->input('is_hidden', 0);
        // cập nhật các trường khác nếu có

        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'Cập nhật bình luận thành công!');
    }


    public function destroy(Comment $comment)
    {

        $comment->update(['is_hidden' => 1]);
        $comment->delete();
        return back()->with('success', 'Đã ẩn và xóa mềm bình luận.');
    }

    public function toggleVisibility($id, Request $request)
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        if ($comment->trashed()) {
            return back()->with('error', 'Bình luận đã bị xóa, không thể thay đổi trạng thái ẩn/hiện.');
        }

        $comment->is_hidden = $request->input('is_hidden');
        $comment->save();

        return back()->with('success', 'Cập nhật trạng thái bình luận thành công.');
    }

    public function restore($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();
        $comment->update(['is_hidden' => 0]);

        return redirect()
            ->route('admin.comments.index', ['status' => 'trashed'])
            ->with('success', 'Khôi phục bình luận thành công và đã hiển thị lại!');
    }

    public function forceDelete($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->forceDelete();

        return redirect()->route('admin.comments.index', ['status' => 'trashed'])->with('success', 'Xóa vĩnh viễn bình luận thành công!');
    }

    public function updateStatus(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'status' => 'required|in:đã duyệt,chờ duyệt,spam,chặn',
        ]);

        $comment->status = $validated['status'];
        $comment->save();

        // dd($comment->status);
        return redirect()->route('admin.comments.index')->with('success', 'Cập nhật trạng thái bình luận thành công.');
    }
}
