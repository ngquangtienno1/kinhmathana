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
        $query = Comment::query()->with('user');

        // Xử lý trạng thái "đã xóa mềm" (trashed hoặc active)
        $status = $request->query('status');

        if ($status === 'trashed') {
            $query = Comment::onlyTrashed()->with('user');
        } elseif ($status === 'active') {
            $query = Comment::whereNull('deleted_at')->with('user');
        } elseif ($status && $status !== 'all') {
            // Các trạng thái status thực trong DB: "chờ duyệt", "đã duyệt", "spam", "chặn"
            $query = Comment::withTrashed()->with('user')->where('status', $status);
        } else {
            // Mặc định: tất cả (kể cả đã xóa mềm)
            $query = Comment::withTrashed()->with('user');
        }

        // Các filter theo entity
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->entity_type === 'news' && $request->filled('news_id')) {
            $query->where('entity_id', $request->news_id);
        }

        if ($request->entity_type === 'product' && $request->filled('product_id')) {
            $query->where('entity_id', $request->product_id);
        }

        // Ngày tạo
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Tìm kiếm
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

        $comments = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Lấy danh sách tin tức & sản phẩm nếu có lọc
        $news = [];
        $products = [];

        if ($request->entity_type === 'news') {
            $news = News::pluck('title', 'id');
        }

        if ($request->entity_type === 'product') {
            $products = Product::pluck('name', 'id');
        }

        // Lấy danh sách các trạng thái hiện có trong DB (distinct)
        $availableStatuses = Comment::select('status')->distinct()->pluck('status');

        // Đếm số lượng bình luận đang hoạt động và đã xóa
        $activeCount = Comment::whereNull('deleted_at')->count();
        $deletedCount = Comment::onlyTrashed()->count();

        return view('admin.comments.index', compact(
            'comments',
            'news',
            'products',
            'status',
            'availableStatuses',
            'activeCount',
            'deletedCount'
        ));
    }




    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(Comment $comment) {}

    public function update(Request $request, Comment $comment) {}

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete(); // XÓA MỀM
        return redirect()->back()->with('success', 'Xóa bình luận thành công.');
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

        return redirect()->route('admin.comments.index', ['status' => 'trashed'])->with('success', 'Khôi phục bình luận thành công!');
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