<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo dữ liệu cho bảng shipping_providers
        $providers = [
            [
                'name' => 'Giao Hàng Tiết Kiệm',
                'code' => 'GHTK',
                'description' => 'Đơn vị giao hàng nhanh chóng, tiết kiệm',
                'logo_url' => 'https://example.com/ghtk-logo.png',
                'api_key' => 'test_api_key_ghtk',
                'api_secret' => 'test_api_secret_ghtk',
                'api_endpoint' => 'https://api.ghtk.vn',
                'api_settings' => json_encode([
                    'version' => '1.0',
                    'timeout' => 30,
                    'retry_attempts' => 3
                ]),
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Vietnam Post',
                'code' => 'VNPOST',
                'description' => 'Bưu điện Việt Nam - Dịch vụ giao hàng toàn quốc',
                'logo_url' => 'https://example.com/vnpost-logo.png',
                'api_key' => 'test_api_key_vnpost',
                'api_secret' => 'test_api_secret_vnpost',
                'api_endpoint' => 'https://api.vnpost.vn',
                'api_settings' => json_encode([
                    'version' => '2.0',
                    'timeout' => 45,
                    'retry_attempts' => 5
                ]),
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Giao Hàng Nhanh',
                'code' => 'GHN',
                'description' => 'Dịch vụ giao hàng nhanh trong ngày',
                'logo_url' => 'https://example.com/ghn-logo.png',
                'api_key' => 'test_api_key_ghn',
                'api_secret' => 'test_api_secret_ghn',
                'api_endpoint' => 'https://api.ghn.vn',
                'api_settings' => json_encode([
                    'version' => '1.5',
                    'timeout' => 25,
                    'retry_attempts' => 4
                ]),
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('shipping_providers')->insert($providers);

        // Tạo dữ liệu cho bảng shipping_fees
        $fees = [
            // GHTK - Hà Nội
            [
                'shipping_provider_id' => 1,
                'province_code' => '01',
                'province_name' => 'Hà Nội',
                'base_fee' => 20000,
                'weight_fee' => 5000,
                'distance_fee' => 0,
                'extra_fees' => json_encode([
                    'insurance_fee' => 1000,
                    'cod_fee' => 2000
                ]),
                'note' => 'Giao hàng nội thành Hà Nội',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // GHTK - TP.HCM
            [
                'shipping_provider_id' => 1,
                'province_code' => '79',
                'province_name' => 'TP.HCM',
                'base_fee' => 25000,
                'weight_fee' => 6000,
                'distance_fee' => 0,
                'extra_fees' => json_encode([
                    'insurance_fee' => 1500,
                    'cod_fee' => 2500
                ]),
                'note' => 'Giao hàng nội thành TP.HCM',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // VNPOST - Hà Nội
            [
                'shipping_provider_id' => 2,
                'province_code' => '01',
                'province_name' => 'Hà Nội',
                'base_fee' => 18000,
                'weight_fee' => 4500,
                'distance_fee' => 0,
                'extra_fees' => json_encode([
                    'insurance_fee' => 800,
                    'cod_fee' => 1800
                ]),
                'note' => 'Giao hàng nội thành Hà Nội',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // VNPOST - TP.HCM
            [
                'shipping_provider_id' => 2,
                'province_code' => '79',
                'province_name' => 'TP.HCM',
                'base_fee' => 22000,
                'weight_fee' => 5500,
                'distance_fee' => 0,
                'extra_fees' => json_encode([
                    'insurance_fee' => 1200,
                    'cod_fee' => 2200
                ]),
                'note' => 'Giao hàng nội thành TP.HCM',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // GHN - Hà Nội
            [
                'shipping_provider_id' => 3,
                'province_code' => '01',
                'province_name' => 'Hà Nội',
                'base_fee' => 30000,
                'weight_fee' => 7000,
                'distance_fee' => 0,
                'extra_fees' => json_encode([
                    'insurance_fee' => 2000,
                    'cod_fee' => 3000
                ]),
                'note' => 'Giao hàng nhanh nội thành Hà Nội',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // GHN - TP.HCM
            [
                'shipping_provider_id' => 3,
                'province_code' => '79',
                'province_name' => 'TP.HCM',
                'base_fee' => 35000,
                'weight_fee' => 8000,
                'distance_fee' => 0,
                'extra_fees' => json_encode([
                    'insurance_fee' => 2500,
                    'cod_fee' => 3500
                ]),
                'note' => 'Giao hàng nhanh nội thành TP.HCM',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('shipping_fees')->insert($fees);
    }
}
