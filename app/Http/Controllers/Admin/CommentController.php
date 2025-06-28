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

        // Filter theo trạng thái
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'đã duyệt');
            } elseif ($request->status === 'trashed') {
                $query->onlyTrashed();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter theo entity_type nếu có
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        // Filter theo entity_id nếu có
        if ($request->filled('entity_id')) {
            $query->where('entity_id', $request->entity_id);
        }

        // Filter theo khoảng thời gian (created_at)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Tìm kiếm theo nội dung hoặc user name/email
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(content) LIKE ?', ['%' . $search . '%'])
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                            ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
                    });
            });
        }

        // Phân trang, ví dụ 10 bản ghi 1 trang
        $comments = $query
            ->with(['user', 'product', 'news'])
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();



        // Đếm các trạng thái để hiển thị filter
        $totalCount = Comment::count();
        $approvedCount = Comment::where('status', 'đã duyệt')->count();
        $pendingCount = Comment::where('status', 'chờ duyệt')->count();
        $spamCount = Comment::where('status', 'spam')->count();
        $blockedCount = Comment::where('status', 'chặn')->count();
        $deletedCount = Comment::onlyTrashed()->count();

        // Lấy danh sách entity_type để chọn filter (nếu muốn)
        $entityTypes = Comment::select('entity_type')->distinct()->pluck('entity_type');

        return view('admin.comments.index', compact(
            'comments',
            'totalCount',
            'approvedCount',
            'pendingCount',
            'spamCount',
            'blockedCount',
            'deletedCount',
            'entityTypes',
        ));
    }


    public function create() {}

    public function store(Request $request) {}

    public function show($id)
    {
        $comment = Comment::with('user', 'replies.user')->findOrFail($id);
        return view('admin.comments.show', compact('comment'));
    }

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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:chờ duyệt,đã duyệt',
        ]);

        $comment = Comment::findOrFail($id);

        $currentStatus = $comment->status;
        $newStatus = $request->status;

        // Danh sách các trạng thái hợp lệ cho từng trạng thái hiện tại
        $statusTransitions = [
            'chờ duyệt' => ['đã duyệt'],
            'đã duyệt' => [],
        ];

        // Kiểm tra key tồn tại
        if (!array_key_exists($currentStatus, $statusTransitions)) {
            return back()->with('error', 'Trạng thái hiện tại không hợp lệ.');
        }

        // Nếu trạng thái không thay đổi thì thôi
        if ($currentStatus === $newStatus) {
            return back()->with('info', 'Trạng thái không có thay đổi.');
        }

        // Kiểm tra xem có được phép chuyển trạng thái không
        if (!in_array($newStatus, $statusTransitions[$currentStatus])) {
            return back()->with('error', 'Không thể chuyển trạng thái từ "' . $currentStatus . '" sang "' . $newStatus . '".');
        }

        // Cập nhật trạng thái
        $comment->status = $newStatus;
        $comment->save();

        return back()->with('success', 'Trạng thái bình luận đã được cập nhật.');
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

        // Lưu số lần vi phạm của mỗi user
        $userViolations = [];

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
                    $comment->is_hidden = true;
                    $comment->save();
                    $blockedCount++;

                    // Đếm số lần vi phạm của user
                    if ($comment->user) {
                        $userId = $comment->user->id;
                        if (!isset($userViolations[$userId])) {
                            $userViolations[$userId] = 0;
                        }
                        $userViolations[$userId]++;
                    }
                }
            } else {
                if ($comment->status === 'chặn') {
                    $comment->status = 'chờ duyệt';
                    $comment->is_hidden = false;
                    $comment->save();
                    $unblockedCount++;
                } elseif ($comment->status === 'chờ duyệt') {
                    $comment->status = 'đã duyệt';
                    $comment->is_hidden = false;
                    $comment->save();
                    $autoApprovedCount++;
                }
            }
        }

        // Khóa user vi phạm từ 3 lần trở lên
        foreach ($userViolations as $userId => $violationCount) {
            if ($violationCount >= 3) {
                $user = \App\Models\User::find($userId);
                if ($user && (is_null($user->banned_until) || now()->gt($user->banned_until))) {
                    $user->banned_until = now()->addDay();
                    $user->save();
                    $bannedUsers[] = $userId;
                }
            }
        }

        return redirect()->route('admin.comments.index', ['status' => 'chặn'])
            ->with('success', "Đã chặn $blockedCount bình luận chứa từ cấm, mở $unblockedCount bình luận và tự động duyệt $autoApprovedCount bình luận sạch. Đã khóa tạm thời " . count($bannedUsers) . " người dùng vi phạm từ 3 lần trở lên.");
    }
    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'reply_content' => 'required|string|max:2000',
        ]);

        // Giả sử Comment có quan hệ replies hoặc bạn lưu bình luận trả lời dưới dạng comment mới liên kết parent_id
        $comment->replies()->create([
            'user_id' => auth()->id(),
            'content' => $request->reply_content,
            'status' => 'đã duyệt',  // hoặc trạng thái phù hợp
            'entity_type' => 'comment',
            'entity_id' => $comment->id,
        ]);

        return redirect()->back()->with('success', 'Đã gửi trả lời bình luận.');
    }
}