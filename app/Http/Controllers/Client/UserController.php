<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class UserController extends Controller
{
    // Hiển thị trang thông tin tài khoản
    public function index()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $totalOrders = $customer ? $customer->total_orders : 0;
        $totalSpent = $customer ? $customer->total_spent : 0;
        $customerType = $customer ? $customer->customer_type : null;
        // Lấy danh sách đơn hàng của user, mới nhất trước, phân trang 10 bản ghi
        $orders = $user->orders()->withCount('items')->orderByDesc('created_at')->paginate(10);
        return view('client.users.index', compact('user', 'customer', 'totalOrders', 'totalSpent', 'customerType', 'orders'));
    }

    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            // Nếu chưa đăng nhập thì chuyển hướng về trang đăng nhập
            return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }
        // Có thể lấy thêm các thông tin liên quan như đơn hàng, địa chỉ, v.v. ở đây
        return view('client.users.information', compact('user'));
    }

    // Cập nhật thông tin tài khoản
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);
        // Cập nhật thông tin cơ bản
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        // Xử lý avatar nếu có upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = uniqid('avatar_').'.'.$avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads/avatars'), $avatarName);
            $user->avatar = 'uploads/avatars/'.$avatarName;
        }
        // Đổi mật khẩu nếu nhập đủ
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (\Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->new_password);
            } else {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
            }
        }
        $user->save();
        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
