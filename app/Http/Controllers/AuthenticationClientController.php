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
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
                return redirect()->route('client.login')->with('blocked', true);
            }


            // Successful login
            $remember = $request->has('remember');
            Auth::login($user, $remember);
            if ($remember) {
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
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
            $user = Auth::user();
            Log::info('User logged out', ['user_id' => $user->id]);
            // Xóa remember_token khi logout
            $user->setRememberToken(null);
            $user->save();
            Auth::logout();
            session()->forget('user_id');
        }

        // Nếu logout do bị chặn/inactive (từ polling hoặc session)
        if (request()->has('blocked') || session('blocked')) {
            return redirect()->route('client.login')->with('blocked', true);
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

    // Hiển thị form quên mật khẩu
    public function showForgotPasswordForm()
    {
        return view('client.login.forgot-password');
    }

    // Gửi mail reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Đã gửi email xác nhận, vui lòng kiểm tra hộp thư của bạn!');
        }
        return back()->withErrors(['email' => 'Không thể gửi email. Vui lòng kiểm tra lại địa chỉ email hoặc thử lại sau.']);
    }

    // Hiển thị form đặt lại mật khẩu
    public function showResetForm(Request $request, $token = null)
    {
        return view('client.login.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // Xử lý đặt lại mật khẩu
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('client.login')->with('status', __($status));
        }
        return back()->withErrors(['email' => [__($status)]]);
    }
}