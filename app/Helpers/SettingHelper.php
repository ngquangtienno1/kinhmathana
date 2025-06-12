<?php

use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Lấy toàn bộ hoặc một phần cấu hình hệ thống.
 *
 * @param string|null $key
 * @return mixed
 */
function getSetting($key = null)
{
    // Cache trong 10 phút
    $setting = Cache::remember('website_settings', now()->addMinutes(5), function () {
        return WebsiteSetting::first(); // Chỉ lấy 1 bản ghi cấu hình hệ thống
    });

    return $key ? ($setting->$key ?? null) : $setting;
}

/**
 * Lấy URL của logo từ cột logo_url.
 *
 * @return string
 */
function getLogoUrl()
{
    $logoUrl = getSetting('logo_url');
    if ($logoUrl) {
        return $logoUrl;
    }
    return asset('images/default-logo.png');
}
