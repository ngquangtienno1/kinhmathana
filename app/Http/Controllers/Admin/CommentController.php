<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\BadWord;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

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

        // Tìm kiếm
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
    public function badWordsIndex()
    {
        $badWords = BadWord::all();
        return view('admin.comments.badwords', compact('badWords'));
    }

    // Thêm từ cấm mới
    public function badWordsStore(Request $request)
    {
        $request->validate([
            'word' => 'required|string|unique:bad_words,word'
        ]);

        BadWord::create(['word' => $request->word]);

        return redirect()->route('admin.comments.badwords.index')->with('success', 'Thêm từ cấm thành công.');
    }

    // Xóa từ cấm
    public function badWordsDestroy(BadWord $badword)
    {
        $badword->delete();

        return redirect()->route('admin.comments.badwords.index')->with('success', 'Xóa từ cấm thành công.');
    }
   public function updateCommentsStatusAndBanUsers()
{
    $badWords = BadWord::pluck('word')->toArray();
    $comments = Comment::where('status', '!=', 'trashed')->get();

    $blockedCount = 0;
    $pendingCount = 0;
    $autoApprovedCount = 0;
    $unblockedCount = 0;
    $bannedUsers = [];

    $usersToBan = [];

    foreach ($comments as $comment) {
        $containsBadWord = false;

        foreach ($badWords as $word) {
            if (stripos($comment->content, $word) !== false) {
                $containsBadWord = true;
                break;
            }
        }

        if ($containsBadWord) {
            if ($comment->status !== 'chặn') {
                $comment->status = 'chặn';
                $comment->save();
                $blockedCount++;
            }

            // Gom các user cần khóa (kể cả comment đã bị chặn rồi)
            if ($comment->user && !in_array($comment->user->id, $bannedUsers)) {
                $usersToBan[$comment->user->id] = $comment->user;
            }

        } else {
            if ($comment->status === 'chặn') {
                $comment->status = 'chờ duyệt';
                $comment->save();
                $unblockedCount++;
            } elseif ($comment->status === 'chờ duyệt') {
                $comment->status = 'đã duyệt';
                $comment->save();
                $autoApprovedCount++;
            }
        }
    }

    // Khóa tất cả user vi phạm mà chưa bị khóa
    foreach ($usersToBan as $user) {
        if (is_null($user->banned_until) || now()->gt($user->banned_until)) {
            $user->banned_until = now()->addHours(24);
            $user->save();
            $bannedUsers[] = $user->id;
        }
    }

    return redirect()->route('admin.comments.index', ['status' => 'chặn'])
        ->with('success', "Đã chặn $blockedCount bình luận chứa từ cấm, mở $unblockedCount bình luận và tự động duyệt $autoApprovedCount bình luận sạch. Đã khóa tạm thời " . count($bannedUsers) . " người dùng.");
}

}
