<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerSupport;
use Illuminate\Support\Facades\Mail;

class CustomerSupportController extends Controller
{
    public function showForm()
    {
        return view('admin.support.support');
    }

    public function index(Request $request)
    {
        $query = CustomerSupport::with('user');

        // Tìm kiếm
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('user', function ($user) use ($q) {
                    $user->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                })
                    ->orWhere('message', 'like', "%{$q}%");
            });
        }

        // Lọc trạng thái
        if ($request->filled('status') && $request->status == 'active') {
            $query->whereIn('status', ['mới', 'đang xử lý']);
        }

        // Sắp xếp
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $supports = $query->get();
        $totalCount = $supports->count();
        $activeCount = $supports->whereIn('status', ['mới', 'đang xử lý'])->count();

        return view('admin.support.support_list', compact('supports', 'totalCount', 'activeCount'));
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required',
        ]);

        CustomerSupport::create([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'status' => 'mới',
        ]);

        return back()->with('success', 'Yêu cầu hỗ trợ của bạn đã được gửi!');
    }

    public function show($id)
    {
        $support = CustomerSupport::with('user')->findOrFail($id);
        return view('admin.support.support_show', compact('support'));
    }

    public function markAsDone($id)
    {
        $support = CustomerSupport::findOrFail($id);
        $support->status = 'đã xử lý';
        $support->save();
        return redirect()->route('admin.support.list')->with('success', 'Đã đánh dấu đã xử lý!');
    }

    public function destroy($id)
    {
        $support = CustomerSupport::findOrFail($id);
        $support->delete();
        return redirect()->route('admin.support.list')->with('success', 'Đã xóa phản hồi!');
    }

    public function editStatus($id)
    {
        $support = CustomerSupport::findOrFail($id);
        return view('admin.support.support_status', compact('support'));
    }

    public function updateStatus(Request $request, $id)
    {
        $support = CustomerSupport::findOrFail($id);
        $request->validate([
            'status' => 'required|in:mới,đang xử lý,đã xử lý',
        ]);
        $support->status = $request->status;
        $support->save();

        // Kiểm tra nếu request đến từ danh sách thì redirect về danh sách
        if (url()->previous() === route('admin.support.list')) {
            return redirect()->route('admin.support.list')->with('success', 'Cập nhật trạng thái thành công!');
        }

        // Mặc định: redirect về trang chi tiết
        return redirect()->route('admin.support.show', $support->id)->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function showEmailForm($id)
    {
        $support = CustomerSupport::with('user')->findOrFail($id);
        return view('admin.support.support_email', compact('support'));
    }

    public function sendEmail(Request $request, $id)
    {
        $support = CustomerSupport::with('user')->findOrFail($id);
        $request->validate([
            'subject' => 'required',
            'content' => 'required',
        ]);

        Mail::raw($request->content, function ($message) use ($support, $request) {
            $message->to($support->user->email)
                ->subject($request->subject);
        });

        return redirect()->route('admin.support.show', $support->id)->with('success', 'Đã gửi email cho khách hàng!');
    }
}
