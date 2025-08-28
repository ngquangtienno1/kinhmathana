<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\News;
use App\Models\Product;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot(): void
    {
        User::observe(UserObserver::class);

        // Chỉ thực hiện cấu hình nếu bảng website_settings tồn tại
        if (Schema::hasTable('website_settings')) {
            Config::set('mail.mailers.smtp.host', getSetting('smtp_host') ?? env('MAIL_HOST', 'default.host.com'));
            Config::set('mail.mailers.smtp.port', getSetting('smtp_port') ?? env('MAIL_PORT', 587));
            Config::set('mail.mailers.smtp.username', getSetting('smtp_username') ?? env('MAIL_USERNAME', 'default@example.com'));
            Config::set('mail.mailers.smtp.password', getSetting('smtp_password') ?? env('MAIL_PASSWORD', 'password'));
            Config::set('mail.mailers.smtp.encryption', getSetting('smtp_encryption') ?? env('MAIL_ENCRYPTION', 'tls'));

            Config::set('mail.from.address', getSetting('mail_from_address') ?? env('MAIL_FROM_ADDRESS', 'no-reply@yourdomain.com'));
            Config::set('mail.from.name', getSetting('mail_from_name') ?? env('MAIL_FROM_NAME', 'Your Website'));
        } else {
            // Cấu hình mặc định từ .env nếu bảng chưa tồn tại
            Config::set('mail.mailers.smtp.host', env('MAIL_HOST', 'default.host.com'));
            Config::set('mail.mailers.smtp.port', env('MAIL_PORT', 587));
            Config::set('mail.mailers.smtp.username', env('MAIL_USERNAME', 'default@example.com'));
            Config::set('mail.mailers.smtp.password', env('MAIL_PASSWORD', 'password'));
            Config::set('mail.mailers.smtp.encryption', env('MAIL_ENCRYPTION', 'tls'));

            Config::set('mail.from.address', env('MAIL_FROM_ADDRESS', 'no-reply@yourdomain.com'));
            Config::set('mail.from.name', env('MAIL_FROM_NAME', 'Your Website'));
        }

        // Truyền biến cartCount cho tất cả view
        View::composer('*', function ($view) {
            $cartCount = 0;
            $cartItems = [];
            if (Auth::check()) {
                // Lấy danh sách sản phẩm trong giỏ cho user đăng nhập
                $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                    ->where('user_id', Auth::id())
                    ->orderBy('updated_at', 'desc')
                    ->get();
                $cartCount = $cartItems->count();
            } else {
                // Lấy danh sách sản phẩm trong session cho khách
                if (session()->has('cart')) {
                    $cart = session('cart');
                    $cartItems = collect($cart);
                    $cartCount = $cartItems->count();
                }
            }
            $view->with('cartCount', $cartCount)->with('cartItems', $cartItems);
        });
    }
}
