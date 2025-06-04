<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }
        if ($request->filled('status_user')) {
            $query->where('status_user', $request->status_user);
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        $users = $query->get();
        $roles = \App\Models\Role::all();
        $allCount = User::count();
        $activeCount = User::where('status_user', 'active')->count();
        $inactiveCount = User::where('status_user', 'inactive')->count();
        $blockedCount = User::where('status_user', 'blocked')->count();
        return view('admin.users.list', compact('users', 'roles', 'allCount', 'activeCount', 'inactiveCount', 'blockedCount'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Không cho phép chỉnh sửa admin mặc định (id = 1) nếu không phải admin gốc
        if ($user->id == 1 && auth()->user()->id != 1) {
            return back()->withErrors(['edit' => 'Bạn không có quyền chỉnh sửa tài khoản admin mặc định!']);
        }

        // Không cho phép tự hạ quyền chính mình
        if (auth()->user()->id == $user->id && auth()->user()->role_id == 1 && $request->role_id != 1) {
            return back()->withErrors(['role_id' => 'Bạn không thể tự hạ quyền Admin của mình!']);
        }

        $request->validate([
            'name' => 'required|string|max:125',
            'email' => 'required|string|email|max:125|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:125',
            'address' => 'nullable|string|max:125',
            'date_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'status_user' => 'nullable|string|max:50',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'required|exists:roles,id'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_birth' => $request->date_birth,
            'gender' => $request->gender,
            'status_user' => $request->status_user,
        ];

        // Chỉ admin mới được phép đổi vai trò
        if (auth()->user()->role_id == 1) {
            // Không cho phép admin khác đổi vai trò của admin mặc định
            if ($user->id == 1 && $request->role_id != 1) {
                return back()->withErrors(['role_id' => 'Không thể thay đổi vai trò của admin mặc định!']);
            }
            $data['role_id'] = $request->role_id;
        } else {
            $data['role_id'] = $user->role_id; // Giữ nguyên vai trò cũ
        }

        // Không cho phép staff đổi email của admin hoặc staff khác
        if (auth()->user()->role_id == 2 && in_array($user->role_id, [1, 2]) && $request->email != $user->email) {
            return back()->withErrors(['email' => 'Bạn không có quyền đổi email của tài khoản này!']);
        }

        // Không cho phép staff reset mật khẩu cho admin hoặc staff khác
        if (auth()->user()->role_id == 2 && in_array($user->role_id, [1, 2]) && $request->filled('password')) {
            return back()->withErrors(['password' => 'Bạn không có quyền đổi mật khẩu tài khoản này!']);
        }

        // Không cho phép đổi trạng thái hoạt động của tài khoản có quyền cao hơn hoặc ngang bằng
        if (auth()->user()->role_id == 2 && in_array($user->role_id, [1, 2]) && $request->status_user != $user->status_user) {
            return back()->withErrors(['status_user' => 'Bạn không có quyền đổi trạng thái tài khoản này!']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                $oldAvatarPath = public_path($user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads/avatars'), $avatarName);
            $data['avatar'] = 'uploads/avatars/' . $avatarName;
        }

        // Handle password update
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật người dùng thành công');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Không cho phép xóa chính mình
        if (auth()->user()->id == $user->id) {
            return back()->withErrors(['delete' => 'Bạn không thể tự xóa tài khoản của mình!']);
        }

        // Chỉ admin mới được xóa tài khoản admin hoặc staff
        if (auth()->user()->role_id != 1 && in_array($user->role_id, [1, 2])) {
            return back()->withErrors(['delete' => 'Bạn không có quyền xóa tài khoản này!']);
        }

        // Không cho phép xóa admin mặc định
        if ($user->id == 1) {
            return back()->withErrors(['delete' => 'Không thể xóa tài khoản admin mặc định!']);
        }

        // Delete avatar if exists
        if ($user->avatar) {
            $oldAvatarPath = public_path($user->avatar);
            if (file_exists($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Xóa người dùng thành công');
    }

    public function profile($id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
        } else {
            $user = Auth::user();
        }
        return view('admin.users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Chỉ validate những trường được gửi lên
        $rules = [];
        if ($request->filled('name')) {
            $rules['name'] = 'required|string|max:255';
        }
        if ($request->filled('email')) {
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $user->id;
        }
        if ($request->filled('phone')) {
            $rules['phone'] = 'nullable|string|max:20';
        }
        if ($request->filled('date_birth')) {
            $rules['date_birth'] = 'nullable|date';
        }
        if ($request->filled('gender')) {
            $rules['gender'] = 'nullable|in:male,female,other';
        }
        if ($request->filled('address')) {
            $rules['address'] = 'nullable|string|max:255';
        }
        if ($request->hasFile('avatar')) {
            $rules['avatar'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validated = $request->validate($rules);

        // Xử lý upload avatar
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                $oldAvatarPath = public_path($user->avatar);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            // Upload avatar mới
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads/avatars'), $avatarName);
            $validated['avatar'] = 'uploads/avatars/' . $avatarName;
        }

        // Cập nhật thông tin người dùng
        $user->update($validated);

        return redirect()->route('admin.users.profile')->with('success', 'Cập nhật thông tin thành công');
    }

    /**
     * Xác thực mật khẩu hiện tại
     */
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string'
        ]);

        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 422);
    }

    /**
     * Cập nhật mật khẩu mới
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.users.profile')
            ->with('success', 'Mật khẩu đã được cập nhật thành công');
    }
}