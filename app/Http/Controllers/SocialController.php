<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();
            if ($user) {
                // Nếu user đã bị chặn thì không cho đăng nhập
                if ($user->status_user !== 'active') {
                    return redirect()->route('client.login')->withErrors(['email' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt']);
                }
                // Cập nhật thông tin cơ bản (trừ status_user)
                $user->update([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                ]);
            } else {
                // Tạo mới user
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname(),
                    'address' => null,
                    'phone' => null,
                    'password' => bcrypt(Str::random(24)),
                    'date_birth' => null,
                    'gender' => null,
                    'status_user' => 'active',
                    'avatar' => $googleUser->getAvatar(),
                    'role_id' => 3,
                    'email' => $googleUser->getEmail(),
                    'email_verified_at' => now(),
                    'phone_verified_at' => null,
                ]);
            }

            Auth::login($user);

            if ($user->role_id == 3) {
                return redirect()->route('client.home')->with('message', 'Đăng nhập Google thành công');
            } else {
                return redirect()->route('admin.home')->with('message', 'Đăng nhập Google thành công');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại: ' . $e->getMessage());
        }
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $user = User::where('email', $facebookUser->getEmail())->first();
            if ($user) {
                if ($user->status_user !== 'active') {
                    return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.');
                }
                $user->update([
                    'name' => $facebookUser->getName() ?? $facebookUser->getNickname(),
                    'email_verified_at' => now(),
                ]);
            } else {
                $user = User::create([
                    'name' => $facebookUser->getName() ?? $facebookUser->getNickname(),
                    'password' => bcrypt(Str::random(24)),
                    'role_id' => 3,
                    'email' => $facebookUser->getEmail(),
                    'status_user' => 'active',
                    'email_verified_at' => now(),
                ]);
            }

            Auth::login($user);

            if ($user->role_id == 3) {
                return redirect()->route('client.home')->with('message', 'Đăng nhập Facebook thành công');
            } else {
                return redirect()->route('admin.home')->with('message', 'Đăng nhập Facebook thành công');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập Facebook thất bại: ' . $e->getMessage());
        }
    }
}
