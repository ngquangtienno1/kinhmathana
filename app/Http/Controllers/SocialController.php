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
                    'password' => bcrypt(Str::random(24)),
                    'role_id' => 2,
                ]
            );

            Auth::login($user);

            return redirect()->route('admin.home')->with('message', 'Đăng nhập Google thành công');
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
                    'role_id' => 1,
                ]
            );

            Auth::login($user);

            return redirect()->route('admin.home')->with('message', 'Đăng nhập Facebook thành công');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập Facebook thất bại: ' . $e->getMessage());
        }
    }
}