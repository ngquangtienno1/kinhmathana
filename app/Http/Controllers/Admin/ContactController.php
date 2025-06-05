<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReply;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Tìm kiếm theo tên, email hoặc số điện thoại
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $contacts = $query->get();
        $deletedCount = ContactMessage::onlyTrashed()->count();
        $newCount = ContactMessage::where('status', 'mới')->count();
        $readCount = ContactMessage::where('status', 'đã đọc')->count();
        $repliedCount = ContactMessage::where('status', 'đã trả lời')->count();
        $ignoredCount = ContactMessage::where('status', 'đã bỏ qua')->count();

        return view('admin.contacts.index', compact('contacts', 'deletedCount', 'newCount', 'readCount', 'repliedCount', 'ignoredCount'));
    }

    public function show($id)
    {
        $contact = ContactMessage::find($id);
        if (!$contact) {
            return redirect()->route('admin.contacts.index')->with('error', 'Không tìm thấy liên hệ này.');
        }
        return view('admin.contacts.show', compact('contact'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        try {
            $messages = [
                'name.required' => 'Vui lòng nhập họ tên',
                'name.max' => 'Họ tên không được vượt quá 255 ký tự',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email không được vượt quá 255 ký tự',
                'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',
                'message.required' => 'Vui lòng nhập nội dung tin nhắn'
            ];

            $dataNew = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string',
                'status' => 'required|in:mới,đã đọc,đã trả lời,đã bỏ qua',
                'note' => 'nullable|string',
                'is_spam' => 'nullable|boolean'
            ], $messages);

            $dataNew['is_spam'] = $request->boolean('is_spam');
            $dataNew['ip_address'] = $request->ip();
            $dataNew['user_agent'] = $request->userAgent();

            ContactMessage::create($dataNew);
            return redirect()->route('admin.contacts.index')->with('success', 'Thêm liên hệ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm liên hệ: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $contact = ContactMessage::find($id);
        if (!$contact) {
            return redirect()->route('admin.contacts.index')->with('error', 'Không tìm thấy liên hệ này.');
        }
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        try {
            $contact = ContactMessage::find($id);
            if (!$contact) {
                return redirect()->route('admin.contacts.index')->with('error', 'Không tìm thấy liên hệ này.');
            }

            $messages = [
                'name.required' => 'Vui lòng nhập họ tên',
                'name.max' => 'Họ tên không được vượt quá 255 ký tự',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email không được vượt quá 255 ký tự',
                'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',
                'message.required' => 'Vui lòng nhập nội dung tin nhắn',
                'status.required' => 'Vui lòng chọn trạng thái',
                'status.in' => 'Trạng thái không hợp lệ'
            ];

            $dataNew = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'message' => 'required|string',
                'status' => 'required|in:mới,đã đọc,đã trả lời,đã bỏ qua',
                'note' => 'nullable|string',
                'is_spam' => 'nullable|boolean'
            ], $messages);

            $dataNew['is_spam'] = $request->boolean('is_spam');

            if ($dataNew['status'] === 'đã trả lời' && !$contact->reply_at) {
                $dataNew['reply_at'] = now();
                $dataNew['replied_by'] = auth()->id();
            }

            $contact->update($dataNew);
            return redirect()->route('admin.contacts.index')->with('success', 'Cập nhật liên hệ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật liên hệ: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $contact = ContactMessage::find($id);
            if (!$contact) {
                return redirect()->route('admin.contacts.index')->with('error', 'Không tìm thấy liên hệ này.');
            }
            $contact->delete();
            return redirect()->route('admin.contacts.index')->with('success', 'Xóa liên hệ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa liên hệ: ' . $e->getMessage());
        }
    }

    public function bin()
    {
        $contacts = ContactMessage::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.contacts.bin', compact('contacts'));
    }

    public function restore($id)
    {
        try {
            $contact = ContactMessage::onlyTrashed()->find($id);
            if (!$contact) {
                return redirect()->route('admin.contacts.bin')->with('error', 'Không tìm thấy liên hệ này trong thùng rác.');
            }
            $contact->restore();
            return redirect()->route('admin.contacts.bin')->with('success', 'Khôi phục liên hệ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi khôi phục liên hệ: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $contact = ContactMessage::onlyTrashed()->find($id);
            if (!$contact) {
                return redirect()->route('admin.contacts.bin')->with('error', 'Không tìm thấy liên hệ này trong thùng rác.');
            }
            $contact->forceDelete();
            return redirect()->route('admin.contacts.bin')->with('success', 'Xóa vĩnh viễn liên hệ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn liên hệ: ' . $e->getMessage());
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        Log::info('Bulk delete IDs:', $ids);
        $existing = ContactMessage::whereIn('id', $ids)->pluck('id')->toArray();
        Log::info('Existing IDs:', $existing);
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một liên hệ để xóa.');
        }
        if (empty($existing)) {
            return redirect()->back()->with('error', 'Không tìm thấy liên hệ nào hợp lệ để xóa.');
        }
        try {
            ContactMessage::whereIn('id', $existing)->delete();
            return redirect()->route('admin.contacts.index')->with('success', 'Đã xóa mềm các liên hệ đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa: ' . $e->getMessage());
        }
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một liên hệ để khôi phục.');
        }
        try {
            ContactMessage::onlyTrashed()->whereIn('id', $ids)->restore();
            return redirect()->route('admin.contacts.bin')->with('success', 'Đã khôi phục các liên hệ đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi khôi phục: ' . $e->getMessage());
        }
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một liên hệ để xóa vĩnh viễn.');
        }
        try {
            ContactMessage::onlyTrashed()->whereIn('id', $ids)->forceDelete();
            return redirect()->route('admin.contacts.bin')->with('success', 'Đã xóa vĩnh viễn các liên hệ đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa vĩnh viễn các liên hệ: ' . $e->getMessage());
        }
    }

    public function reply($id)
    {
        $contact = ContactMessage::find($id);
        if (!$contact) {
            return redirect()->route('admin.contacts.index')->with('error', 'Không tìm thấy liên hệ này.');
        }
        return view('admin.contacts.reply', compact('contact'));
    }

    public function sendReply(Request $request, $id)
    {
        try {
            $contact = ContactMessage::find($id);
            if (!$contact) {
                return redirect()->route('admin.contacts.index')->with('error', 'Không tìm thấy liên hệ này.');
            }

            $messages = [
                'subject.required' => 'Vui lòng nhập tiêu đề email',
                'subject.max' => 'Tiêu đề email không được vượt quá 255 ký tự',
                'reply_message.required' => 'Vui lòng nhập nội dung phản hồi'
            ];

            $data = $request->validate([
                'subject' => 'required|string|max:255',
                'reply_message' => 'required|string',
                'save_as_note' => 'nullable|boolean'
            ], $messages);

            Mail::to($contact->email)->send(new ContactReply($contact, $data['subject'], $data['reply_message']));

            $contact->update([
                'status' => 'đã trả lời',
                'reply_at' => now(),
                'replied_by' => auth()->id(),
                'note' => $request->boolean('save_as_note') ? $data['reply_message'] : $contact->note
            ]);

            return redirect()
                ->route('admin.contacts.show', $contact->id)
                ->with('success', 'Đã gửi phản hồi thành công!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra khi gửi phản hồi: ' . $e->getMessage())
                ->withInput();
        }
    }
}