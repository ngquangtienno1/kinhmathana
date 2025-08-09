<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebsiteSetting;

class WebsiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = WebsiteSetting::first();

        if (!$settings) {
            WebsiteSetting::create([
                'website_name' => 'Hana Optical',
                'contact_email' => 'info@hanaoptical.com',
                'hotline' => '0123456789',
                'address' => '123 Đường ABC, Quận 1, TP.HCM',
                'facebook_url' => 'https://facebook.com/hanaoptical',
                'instagram_url' => 'https://instagram.com/hanaoptical',
                'default_shipping_fee' => 30000,
                'enable_ai_recommendation' => true,
                'ai_api_key' => 'AIzaSyA6CQ7xqq-OLRYERwoJfmwEo7_w30uqzw0',
                'ai_api_endpoint' => 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent',
                'ai_chat_enabled' => true,
                'ai_guest_limit' => 5,
                'ai_user_limit' => 20,
            ]);
        } else {
            // Cập nhật settings hiện có nếu thiếu các trường mới
            $settings->update([
                'ai_chat_enabled' => $settings->ai_chat_enabled ?? true,
                'ai_guest_limit' => $settings->ai_guest_limit ?? 5,
                'ai_user_limit' => $settings->ai_user_limit ?? 20,
                'ai_api_key' => $settings->ai_api_key ?? 'AIzaSyA6CQ7xqq-OLRYERwoJfmwEo7_w30uqzw0',
                'ai_api_endpoint' => $settings->ai_api_endpoint ?? 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent',
            ]);
        }
    }
}
