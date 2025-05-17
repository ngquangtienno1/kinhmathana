<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('website_settings')->insert([
            'website_name' => 'Hana Optical',
            'logo_url' => 'https://hanaoptical.com/logo.png',
            'contact_email' => 'contact@hanaoptical.com',
            'hotline' => '1900 1234',
            'address' => '123 Đường ABC, Quận XYZ, TP.HCM',
            'facebook_url' => 'https://facebook.com/hanaoptical',
            'instagram_url' => 'https://instagram.com/hanaoptical',

            // Cấu hình vận chuyển
            'default_shipping_fee' => 30000,
            'shipping_providers' => json_encode([
                'GHTK' => true,
                'VNPOST' => true,
                'GHN' => true
            ]),
            'shipping_fee_by_province' => json_encode([
                '01' => [ // Hà Nội
                    'GHTK' => 20000,
                    'VNPOST' => 18000,
                    'GHN' => 30000
                ],
                '79' => [ // TP.HCM
                    'GHTK' => 25000,
                    'VNPOST' => 22000,
                    'GHN' => 35000
                ]
            ]),

            // Cấu hình email
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '587',
            'smtp_username' => 'noreply@hanaoptical.com',
            'smtp_password' => 'your_smtp_password',
            'smtp_encryption' => 'tls',
            'mail_from_address' => 'noreply@hanaoptical.com',
            'mail_from_name' => 'Hana Optical',

            // Cấu hình AI gợi ý sản phẩm
            'enable_ai_recommendation' => true,
            'ai_api_key' => 'your_ai_api_key',
            'ai_api_endpoint' => 'https://api.ai-service.com/v1',
            'ai_settings' => json_encode([
                'model' => 'gpt-4',
                'temperature' => 0.7,
                'max_tokens' => 150,
                'recommendation_count' => 5,
                'categories' => [
                    'glasses',
                    'sunglasses',
                    'contact_lenses'
                ]
            ]),

            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
