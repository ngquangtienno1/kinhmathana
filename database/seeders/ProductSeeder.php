<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\Spherical;
use App\Models\Cylindrical;
use Illuminate\Support\Facades\Log;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Tạo dữ liệu mẫu cho các thuộc tính nếu chưa có
            $this->createAttributes();
            
            // Tạo sản phẩm
            $this->createProducts();
        } catch (\Exception $e) {
            Log::error('Lỗi khi chạy ProductSeeder: ' . $e->getMessage());
            throw $e;
        }
    }

    private function createAttributes(): void
    {
        // Tạo màu sắc
        $colors = ['Đen', 'Nâu', 'Trong suốt', 'Vàng gold'];
        foreach ($colors as $color) {
            Color::firstOrCreate(['name' => $color]);
        }

        // Tạo kích thước
        $sizes = ['48–50mm', '51–54mm', '55mm ⬆️'];
        foreach ($sizes as $size) {
            Size::firstOrCreate(['name' => $size]);
        }

        // Tạo độ cận
        $sphericals = ['0.25', '0.50', '0.75', '1.00', '1.25', '1.50'];
        foreach ($sphericals as $spherical) {
            Spherical::firstOrCreate(['name' => $spherical]);
        }

        // Tạo độ loạn
        $cylindricals = ['0.25', '0.50', '0.75', '1.00', '1.25', '1.50'];
        foreach ($cylindricals as $cylindrical) {
            Cylindrical::firstOrCreate(['name' => $cylindrical]);
        }
    }

    private function createProducts(): void
    {
        // Tạo 3 sản phẩm đơn giản
        Product::factory()
            ->count(3)
            ->state(['product_type' => 'simple'])
            ->create();

        // Tạo 3 sản phẩm có biến thể
        Product::factory()
            ->count(3)
            ->state(['product_type' => 'variable'])
            ->create();
    }
}
