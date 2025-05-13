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
    $setting = Cache::remember('website_settings', now()->addMinutes(10), function () {
        return WebsiteSetting::first(); // Chỉ lấy 1 bản ghi cấu hình hệ thống
    });

    return $key ? ($setting->$key ?? null) : $setting;
}

/**
 * Lấy URL của logo từ cột logo_id (giả sử bạn lưu trong bảng media hoặc uploads).
 *
 * @return string
 */
function getLogoUrl()
{
    $logoId = getSetting('logo_id');

    if (!$logoId) {
        return asset('images/default-logo.png'); // fallback nếu chưa có logo
    }

    // Giả sử bạn dùng model Media hoặc lưu file theo tên file
    $logo = \App\Models\UploadFile::find($logoId);
    return $logo ? asset('storage/' . $logo->file_path) : asset('images/default-logo.png');
}
