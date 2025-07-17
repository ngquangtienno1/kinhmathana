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
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AuthenticationController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('admin.login.login');
    }

    public function postLogin(UserLoginRequest $request)
    {
        try {
            // Check email
            $user = User::where('email', $request->email)
                ->with('role')
                ->first();

            if (!$user) {
                Log::warning('Login attempt failed: Email not found', ['email' => $request->email]);
                return redirect()->back()
                    ->withErrors(['email' => 'Email chưa được đăng ký'])
                    ->withInput();
            }

            // Check password
            if (!Hash::check($request->password, $user->password)) {
                Log::warning('Login attempt failed: Invalid password', ['email' => $request->email]);
                return redirect()->back()
                    ->withErrors(['password' => 'Mật khẩu không đúng'])
                    ->withInput();
            }

            // Check account status
            if ($user->status_user !== 'active') {
                Log::warning('Login attempt failed: Account not active', ['email' => $request->email]);
                return redirect()->back()
                    ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt'])
                    ->withInput();
            }


            // Login successful
            Auth::login($user, $request->has('remember'));
            session()->put('user_id', Auth::id());

            // Force new remember_token if 'remember' is checked
            if ($request->has('remember')) {
                $user->setRememberToken(Str::random(60));
                $user->save();
            }

            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role_id' => $user->role_id
            ]);

            // Redirect based on role_id
            if (in_array($user->role_id, [1, 2])) { // 1 là admin, 2 là staff
                return redirect()->route('admin.home')
                    ->with('message', 'Đăng nhập thành công');
            } else if ($user->role_id == 3) {
                return redirect()->route('client');
            } else {
                Auth::logout(); // Đăng xuất ngay lập tức
                return redirect()->route('login')
                    ->withErrors(['email' => 'Tài khoản không hợp lệ']);
            }
        } catch (\Exception $e) {
            Log::error('Login error', [
                'email' => $request->email,
                'error' => $e->getMessage()
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
            // Clear remember_token for security
            $user->setRememberToken(null);
            $user->save();
            Auth::logout();
            session()->forget('user_id');
        }

        return redirect()->route('login')
            ->with('message', 'Đăng xuất thành công');
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
            'role_id' => 3,
            'status_user' => 'active',
            'created_at' => Carbon::now(),
        ]);

        if ($user) {
            return redirect()->route('client.login')->with([
                'message' => 'Đăng ký thành công. Vui lòng đăng nhập'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Có lỗi xảy ra, vui lòng thử lại'
        ]);
    }
}