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

    // Cập nhật thông tin tài khoản (không đổi mật khẩu trực tiếp)
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => [
                'nullable',
                'regex:/^\d{10}$/',
            ],
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'phone.regex' => 'Số điện thoại phải có 10 chữ số.',
        ]);
        // Cập nhật thông tin cơ bản
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        // Xử lý avatar nếu có upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = uniqid('avatar_').'.'.$avatar->getClientOriginalExtension();
            $avatar->move(public_path('uploads/avatars'), $avatarName);
            $user->avatar = 'uploads/avatars/'.$avatarName;
        }
        $user->save();
        return back()->with('success1', 'Cập nhật thông tin thành công!');
    }

    // Gửi OTP về email để đổi mật khẩu
    public function sendOtp(Request $request)
    {
        $user = Auth::user();
        $email = $request->input('email');
        if (!$user || $user->email !== $email) {
            return response()->json(['success' => false, 'message' => 'Email không hợp lệ hoặc không trùng với tài khoản đang đăng nhập.']);
        }
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);
        \App\Models\PasswordOtp::where('user_id', $user->id)->update(['used' => true]); // Hủy các OTP cũ
        $otpModel = \App\Models\PasswordOtp::create([
            'user_id' => $user->id,
            'email' => $email,
            'otp_code' => $otp,
            'expires_at' => $expiresAt,
            'used' => false,
        ]);
        \Mail::to($email)->send(new \App\Mail\SendPasswordOtp($otp));
        return response()->json(['success' => true]);
    }

    // Đổi mật khẩu qua OTP
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        if (!$user || $user->email !== $request->email) {
            return back()->withErrors(['email' => 'Email không hợp lệ hoặc không trùng với tài khoản đang đăng nhập.']);
        }
        $otpModel = \App\Models\PasswordOtp::where('user_id', $user->id)
            ->where('email', $request->email)
            ->where('otp_code', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();
        if (!$otpModel) {
            return back()->withErrors(['otp' => 'Mã OTP không đúng hoặc đã hết hạn.']);
        }
        $user->password = bcrypt($request->new_password);
        $user->save();
        $otpModel->used = true;
        $otpModel->save();
        return back()->with('success1', 'Đổi mật khẩu thành công!');
    }
}
