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

       $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName() ?? $googleUser->getNickname(),
                'address' => null, // Bạn có thể thêm trường address nếu cần (hoặc lấy từ Google nếu có)
                'phone' => null,    // Bạn có thể thêm trường phone nếu có dữ liệu từ Google
                'password' => bcrypt(Str::random(24)), // Mật khẩu ngẫu nhiên
                'date_birth' => null, // Bạn có thể lấy ngày sinh từ Google nếu có (chỉnh sửa nếu Google trả về thông tin này)
                'gender' => null, // Bạn có thể thêm thông tin giới tính nếu có (hoặc từ Google)
                'status_user' => 'active', // Trạng thái mặc định
                'avatar' => $googleUser->getAvatar(), // Lưu ảnh đại diện từ Google
                'role_id' => 3, // Gán vai trò mặc định (có thể thay đổi tùy nhu cầu)
                'email_verified_at' => now(), // Thời gian xác minh email
                'phone_verified_at' => null, // Nếu có thông tin điện thoại, bạn có thể cập nhật tương tự
            ]
        );

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

            $user = User::updateOrCreate(
                ['email' => $facebookUser->getEmail()],
                [
                    'name' => $facebookUser->getName() ?? $facebookUser->getNickname(),
                    'password' => bcrypt(Str::random(24)),
                    'role_id' => 3,
                ]
            );

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