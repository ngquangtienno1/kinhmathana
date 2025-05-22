<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSupport;

class ProductSupportController extends Controller
{
    public function showForm()
    {
        return view('admin.support.support');
    }

    public function index(Request $request)
    {
        $supports = ProductSupport::orderByDesc('created_at')->paginate(20);
        return view('admin.support.support_list', compact('supports'));
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        ProductSupport::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'mới',
        ]);

        return back()->with('success', 'Yêu cầu hỗ trợ của bạn đã được gửi!');
    }

    public function show($id)
    {
        $support = \App\Models\ProductSupport::findOrFail($id);
        return view('admin.support.support_show', compact('support'));
    }

    public function markAsDone($id)
    {
        $support = \App\Models\ProductSupport::findOrFail($id);
        $support->status = 'đã xử lý';
        $support->save();
        return redirect()->route('admin.products.support.list')->with('success', 'Đã đánh dấu đã xử lý!');
    }

    public function destroy($id)
    {
        $support = \App\Models\ProductSupport::findOrFail($id);
        $support->delete();
        return redirect()->route('admin.products.support.list')->with('success', 'Đã xóa phản hồi!');
    }

    public function editStatus($id)
    {
        $support = \App\Models\ProductSupport::findOrFail($id);
        return view('admin.support.support_status', compact('support'));
    }

    public function updateStatus(Request $request, $id)
    {
        $support = \App\Models\ProductSupport::findOrFail($id);
        $request->validate([
            'status' => 'required|in:chưa giải quyết,đang xử lý,đã giải quyết',
        ]);
        $support->status = $request->status;
        $support->save();
        return redirect()->route('admin.products.support.show', $support->id)->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function showEmailForm($id)
    {
        $support = \App\Models\ProductSupport::findOrFail($id);
        return view('admin.support.support_email', compact('support'));
    }

    public function sendEmail(Request $request, $id)
    {
        $support = \App\Models\ProductSupport::findOrFail($id);
        $request->validate([
            'subject' => 'required',
            'content' => 'required',
        ]);
        \Mail::raw($request->content, function($message) use ($support, $request) {
            $message->to($support->email)
                ->subject($request->subject);
        });
        return redirect()->route('admin.products.support.show', $support->id)->with('success', 'Đã gửi email cho khách hàng!');
    }
} 