<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\ChatMessage;

class ChatAdminController extends Controller
{
    public function index(Request $request)
    {
        $adminId = auth()->id();
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
        $auth = auth()->user();
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
        $from = auth()->user();
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
}