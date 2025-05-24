<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TicketNote;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::query();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'trashed') {
                $query = Ticket::onlyTrashed();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Search theo title, description hoặc thông tin người tạo ticket
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                            ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"]);
                    });
            });
        }

        // Sort
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Lấy kết quả với phân trang
        $tickets = $query->get();

        // Đếm tổng số và theo trạng thái (đã xóa mềm cũng đếm)
        $totalCount = Ticket::count();
        $openCount = Ticket::where('status', 'mới')->count();
        $pendingCount = Ticket::where('status', 'chờ khách')->count();
        $dangxulyCount = Ticket::where('status', 'đang xử lý')->count();
        $closedCount = Ticket::where('status', 'đã đóng')->count();
        $trashedCount = Ticket::onlyTrashed()->count();

        // Nếu có dữ liệu liên quan để lọc, ví dụ categories, user,... bạn có thể thêm

        return view('admin.tickets.index', compact(
            'tickets',
            'totalCount',
            'openCount',
            'pendingCount',
            'dangxulyCount',
            'closedCount',
            'trashedCount'
        ));
    }




    public function show($id)
    {
        $ticket = Ticket::with(['user', 'assignedUser'])->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::with('notes.user')->findOrFail($id); // phải load cả user để view không lỗi
        $users = User::orderBy('name')->get();

        return view('admin.tickets.edit', compact('ticket', 'users'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'status' => 'required|in:mới,đang xử lý,chờ khách,đã đóng',
            'priority' => 'required|in:thấp,trung bình,cao,khẩn cấp',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->update($request->only('status', 'priority', 'assigned_to'));

        return redirect()->route('admin.tickets.index')->with('success', 'Cập nhật ticket thành công');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket đã được đưa vào thùng rác');
    }

    public function trashed()
    {
        $tickets = Ticket::onlyTrashed()->paginate(10);
        return view('admin.tickets.trashed', compact('tickets'));
    }

    public function restore($id)
    {
        $ticket = Ticket::onlyTrashed()->findOrFail($id);
        $ticket->restore();
        return redirect()->route('admin.tickets.index')->with('success', 'Khôi phục ticket thành công');
    }

    public function forceDelete($id)
    {
        $ticket = Ticket::onlyTrashed()->findOrFail($id);
        $ticket->forceDelete();
        return redirect()->route('admin.tickets.index')->with('success', 'Xoá vĩnh viễn ticket');
    }

    public function updateStatus(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $request->validate([
            'status' => 'required|in:new,processing,waiting_customer,closed',
        ]);
        $ticket->update(['status' => $request->status]);
        return back()->with('success', 'Cập nhật trạng thái thành công');
    }

    public function toggleVisibility($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->is_visible = !$ticket->is_visible;
        $ticket->save();
        return back()->with('success', 'Đã thay đổi trạng thái hiển thị');
    }
    public function storeNote(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'content' => 'required|string|max:1000',
        ]);

        TicketNote::create([
            'ticket_id' => $request->ticket_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Đã thêm ghi chú nội bộ.');
    }

    // ===== XÓA GHI CHÚ =====
    public function deleteNote($id)
    {
        $note = TicketNote::findOrFail($id);

        // Nếu muốn chỉ người tạo hoặc admin xóa được, thêm điều kiện ở đây

        $note->delete();

        return back()->with('success', 'Ghi chú đã được xóa.');
    }
    public function storeMessage(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'user_id' => Auth::id(), // người gửi
            'message' => $request->message,
        ]);

        return back()->with('success', 'Đã gửi tin nhắn.');
    }
}
