<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AuthenticationClientController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct() {}

    public function login()
    {

        return view('client.login.login');
    }
    public function postLogin(UserLoginRequest $request)
    {
        try {
            // Check email
            $user = User::where('email', $request->email)
                ->with('role')
                ->first();

            if (!$user) {
                Log::warning('Login failed: Email does not exist', ['email' => $request->email]);
                return redirect()->back()
                    ->withErrors(['email' => 'Email chưa được đăng ký'])
                    ->withInput();
            }

            // Check password
            if (!Hash::check($request->password, $user->password)) {
                Log::warning('Login failed: Incorrect password', ['email' => $request->email]);
                return redirect()->back()
                    ->withErrors(['password' => 'Mật khẩu không đúng'])
                    ->withInput();
            }

            // Check user status
            if ($user->status_user !== 'active') {
                Log::warning('Login failed: Account is inactive', ['email' => $request->email]);
                return redirect()->back()
                    ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt'])
                    ->withInput();
            }

            // Successful login
            Auth::login($user, $request->has('remember'));
            session()->put('user_id', Auth::id());

            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role_id' => $user->role_id
            ]);

            if ($user->role_id === 3) { // If the user is a client
                return redirect()->route('client.home') // Redirect to client home page
                    ->with('message', 'Đăng nhập thành công');
            }
        } catch (\Exception $e) {
            // Ghi chi tiết lỗi, bao gồm cả stack trace
            Log::error('Login error', [
                'email' => $request->email,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'stack_trace' => $e->getTraceAsString(), // Thêm thông tin stack trace để debug
            ]);

            return redirect()->back()
                ->withErrors(['email' => 'Có lỗi xảy ra, vui lòng thử lại sau'])
                ->withInput();
        }
    }




    public function logout()
    {
        if (Auth::check()) {
            Log::info('User logged out', ['user_id' => Auth::id()]);
            Auth::logout();
            session()->forget('user_id');
        }

        return redirect()->route('client.login')
            ->with('message', 'Đăng xuất thành công');
    }

    public function register()
    {
        return view('client.login.register');
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
            'role_id' => 3,
            'status_user' => 'active',
            'created_at' => Carbon::now(),
        ]);

        if ($user) {
            Auth::login($user);
            return redirect()->route('client.home')->with([
                'message' => 'Đăng ký thành công. Chào mừng bạn!'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Có lỗi xảy ra, vui lòng thử lại'
        ]);
    }
}
