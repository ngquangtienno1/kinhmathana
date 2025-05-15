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
    public function postLogin(UserLoginRequest $request)
    {
        // $request->validate([
        //     'email' => 'required|email|exists:users,email',
        //     'password' => 'required|string|min:8',
        // ], [
        //     'email.required' => 'Không được để trống email',
        //     'email.email' => 'Email không đúng định dạng ',
        //     'email.exists'=> 'Email chưa được đăng ký',
        //     'password.required'=>'Không được để trống password',
        //     'password.string'=> 'Password không phải là chuỗi',
        //     'password.min'=> 'Password phải trên 8 ký tự'
        // ]);
        $dataUserLogin = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $remember = $request->has('remember');

        if (Auth::attempt($dataUserLogin, $remember)) {
            //Logout het tai khoan khac
            Session::where('user_id', Auth::id())->delete();
            // Tao phien dang nhap moi
            session()->put('user_id', Auth::id());
            if (Auth::user()->role == 1) {
                return redirect()->route('admin')->with([
                    'message' => 'Đăng nhập thành công'
                ]);
            } else {
                return redirect()->route('login')->with([
                    'message' => 'Đăng nhập thất bại'
                ]);
            }
        } else {
            return redirect()->back()->with([
                'message' => 'Email hoặc password không đúng'
            ]);
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
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự'
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