<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\ChatMessage;
use App\Events\MessageDeleted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatAdminController extends Controller
{
    public function index(Request $request)
    {
        $adminId = Auth::id();
        $query = $request->input('q');
        $users = User::where('role_id', 3)
            ->whereHas('messages', function ($q) use ($adminId) {
                $q->where('from_id', $adminId)->orWhere('to_id', $adminId);
            });
        if ($query) {
            $users = $users->where('name', 'like', '%' . $query . '%');
        }
        $users = $users->get();
        return view('admin.chat.index', compact('users'));
    }

    public function conversation(User $user)
    {
        $auth = Auth::user();
        $adminId = 1;
        if ($auth && $auth->role_id == 1) {
            $otherId = $user->id;
            $myId = $auth->id;
        } else {
            $otherId = $adminId;
            $myId = $user->id;
        }
        $messages = Message::where(function ($q) use ($myId, $otherId) {
            $q->where('from_id', $myId)->where('to_id', $otherId);
        })->orWhere(function ($q) use ($myId, $otherId) {
            $q->where('from_id', $otherId)->where('to_id', $myId);
        })->orderBy('created_at')->get();

        return response()->json([
            'messages' => $messages,
            'user' => $user
        ]);
    }

    public function send(Request $request)
    {
        $from = Auth::user();
        $from_id = $from ? $from->id : null;
        $from_name = $from ? $from->name : 'Khách';
        $from_avatar = $from ? ($from->avatar ? asset($from->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png') : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png';
        $to_id = $request->input('to_id');
        $message = $request->input('message');

        $msg = Message::create([
            'from_id' => $from_id,
            'to_id' => $to_id,
            'message' => $message,
        ]);

        event(new ChatMessage($from_id, $from_name, $to_id, $message, $from_avatar));
        return response()->json(['status' => 'sent', 'message' => $msg]);
    }

    public function sendImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'to_id' => 'required|integer'
        ]);

        $from = Auth::user();
        $from_id = $from ? $from->id : null;
        $from_name = $from ? $from->name : 'Khách';
        $from_avatar = $from ? ($from->avatar ? asset($from->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png') : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png';

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('chat/images', $imageName, 'public');

        $msg = Message::create([
            'from_id' => $from_id,
            'to_id' => $request->to_id,
            'message' => '[IMAGE]',
            'attachment' => $imagePath,
            'type' => 'image'
        ]);

        event(new ChatMessage($from_id, $from_name, $request->to_id, '[IMAGE]', $from_avatar, $imagePath, 'image'));
        return response()->json(['status' => 'sent', 'message' => $msg]);
    }

    public function sendVoice(Request $request)
    {
        $request->validate([
            'voice' => 'required|file|mimes:mp3,wav,ogg,webm|max:10240', // 10MB max
            'to_id' => 'required|integer'
        ]);

        $from = Auth::user();
        $from_id = $from ? $from->id : null;
        $from_name = $from ? $from->name : 'Khách';
        $from_avatar = $from ? ($from->avatar ? asset($from->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png') : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png';

        $voice = $request->file('voice');
        $voiceName = time() . '_' . $voice->getClientOriginalName();
        $voicePath = $voice->storeAs('chat/voice', $voiceName, 'public');

        $msg = Message::create([
            'from_id' => $from_id,
            'to_id' => $request->to_id,
            'message' => '[VOICE]',
            'attachment' => $voicePath,
            'type' => 'voice'
        ]);

        event(new ChatMessage($from_id, $from_name, $request->to_id, '[VOICE]', $from_avatar, $voicePath, 'voice'));
        return response()->json(['status' => 'sent', 'message' => $msg]);
    }

    public function sendFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'to_id' => 'required|integer'
        ]);

        $from = Auth::user();
        $from_id = $from ? $from->id : null;
        $from_name = $from ? $from->name : 'Khách';
        $from_avatar = $from ? ($from->avatar ? asset($from->avatar) : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png') : 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png';

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('chat/files', $fileName, 'public');

        $msg = Message::create([
            'from_id' => $from_id,
            'to_id' => $request->to_id,
            'message' => $file->getClientOriginalName(),
            'attachment' => $filePath,
            'type' => 'file'
        ]);

        event(new ChatMessage($from_id, $from_name, $request->to_id, $file->getClientOriginalName(), $from_avatar, $filePath, 'file'));
        return response()->json(['status' => 'sent', 'message' => $msg]);
    }

    public function editMessage(Request $request)
    {
        $request->validate([
            'message_id' => 'required',
            'new_message' => 'required|string|max:1000'
        ]);

        try {
            $message = Message::findOrFail($request->message_id);

            // Kiểm tra quyền chỉnh sửa (chỉ admin mới được chỉnh sửa)
            if (Auth::id() != $message->from_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền chỉnh sửa tin nhắn này'
                ]);
            }

            $message->update([
                'message' => $request->new_message
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tin nhắn đã được cập nhật'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật tin nhắn: ' . $e->getMessage()
            ]);
        }
    }



    public function deleteMessage(Request $request)
    {
        $request->validate([
            'message_id' => 'required'
        ]);

        try {
            $message = Message::findOrFail($request->message_id);

            // Kiểm tra quyền xóa (chỉ admin mới được xóa)
            if (Auth::id() != $message->from_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền xóa tin nhắn này'
                ]);
            }

            // Lưu thông tin trước khi xóa để broadcast
            $messageId = $message->id;
            $fromId = $message->from_id;
            $toId = $message->to_id;

            // Xóa file đính kèm nếu có
            if ($message->attachment && Storage::disk('public')->exists($message->attachment)) {
                Storage::disk('public')->delete($message->attachment);
            }

            $message->delete();

            // Broadcast event xóa tin nhắn
            event(new MessageDeleted($messageId, $fromId, $toId));

            return response()->json([
                'success' => true,
                'message' => 'Tin nhắn đã được xóa'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa tin nhắn: ' . $e->getMessage()
            ]);
        }
    }
}
