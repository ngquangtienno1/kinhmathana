<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

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
        // Lấy từ DB hoặc cache qua helper
        Config::set('mail.mailers.smtp.host', getSetting('smtp_host'));
        Config::set('mail.mailers.smtp.port', getSetting('smtp_port'));
        Config::set('mail.mailers.smtp.username', getSetting('smtp_username'));
        Config::set('mail.mailers.smtp.password', getSetting('smtp_password'));
        Config::set('mail.mailers.smtp.encryption', getSetting('smtp_encryption'));

        Config::set('mail.from.address', getSetting('mail_from_address'));
        Config::set('mail.from.name', getSetting('mail_from_address'));
    }
}
