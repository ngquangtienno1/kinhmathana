<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('admin.login.login');
    }
    public function postLogin(Request $request)
    {
        // Check email trước
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'Email chưa được đăng ký',
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'password' => 'Mật khẩu không đúng',
            ])->withInput();
        }

        // Đúng cả email và password -> login
        Auth::login($user, $request->has('remember'));

        session()->put('user_id', Auth::id());
        if (Auth::user()->role == 1) {
            return redirect()->route('admin.listUser')->with('message', 'Đăng nhập thành công');
        } else {
            return redirect()->route('home')->with('message', 'Đăng nhập thành công');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with([
            'message' => 'Dang xuat thanh cong'
        ]);
    }

    public function register()
    {
        return view('admin.login.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
            'created_at' => Carbon::now(),
        ]);

        if ($user) {
            return redirect()->route('login')->with([
                'message' => 'Đăng ký thành công. Vui lòng đăng nhập'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Có lỗi xảy ra, vui lòng thử lại'
        ]);
    }
}