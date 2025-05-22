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
        $status = $request->query('status');
        $query = Comment::query()->with('user');

        // Xử lý các trạng thái đặc biệt
        if ($status === 'trashed') {
            $query = Comment::onlyTrashed()->with('user');
        } elseif ($status === 'active') {
            $query = Comment::whereNull('deleted_at')->where('is_hidden', false)->with('user');
        } elseif ($status === 'hidden') {
            $query = Comment::whereNull('deleted_at')->where('is_hidden', true)->with('user');
        } elseif ($status && $status !== 'all') {
            // Các trạng thái lưu trong cột `status`
            $query = Comment::withTrashed()->with('user')->where('status', $status);
        } else {
            $query = Comment::whereNull('deleted_at')->with('user');
        }

        // Filter theo entity_type
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        // Filter theo entity_id (tùy loại)
        if ($request->entity_type === 'news' && $request->filled('news_id')) {
            $query->where('entity_id', $request->news_id);
        }

        if ($request->entity_type === 'product' && $request->filled('product_id')) {
            $query->where('entity_id', $request->product_id);
        }

        // Lọc theo ngày tạo
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Tìm kiếm theo nội dung, entity_id hoặc thông tin người dùng
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhere('entity_id', $search)
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Phân trang
        $comments = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Lấy danh sách tin tức và sản phẩm (nếu lọc theo entity)
        $news = [];
        $products = [];

        if ($request->entity_type === 'news') {
            $news = News::pluck('title', 'id');
        }

        if ($request->entity_type === 'product') {
            $products = Product::pluck('name', 'id');
        }

        // Lấy các status khác nhau trong DB (trừ null)
        $availableStatuses = Comment::select('status')->distinct()->whereNotNull('status')->pluck('status');

        // Đếm số lượng đang hoạt động và đã xóa
        $activeCount = Comment::whereNull('deleted_at')->where('is_hidden', 0)->count();
        $hiddenCount = Comment::whereNull('deleted_at')->where('is_hidden', 1)->count();
        $deletedCount = Comment::onlyTrashed()->count();

        return view('admin.comments.index', compact(
            'comments',
            'news',
            'products',
            'status',
            'availableStatuses',
            'activeCount',
            'hiddenCount',
            'deletedCount'
        ));
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
