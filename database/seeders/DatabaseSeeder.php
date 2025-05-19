<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tắt kiểm tra foreign key để tránh lỗi khi xóa dữ liệu
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Xóa dữ liệu cũ từ các bảng
        $this->cleanDatabase();

        // Bật lại kiểm tra foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Chạy các seeder theo thứ tự
        $this->call([
            // 1. Seeder cho các bảng cơ bản
            RoleSeeder::class,        // Tạo roles trước
            RolePermissionSeeder::class, // Tạo permissions và gán cho roles

            // 2. Seeder cho người dùng
            UserSeeder::class,        // Tạo users với role_id

            // 3. Seeder cho danh mục và thương hiệu
            CategorySeeder::class,    // Tạo categories
            BrandSeeder::class,       // Tạo brands

            // 4. Seeder cho sản phẩm và liên quan
            ProductSeeder::class,     // Tạo products
            ProductImageSeeder::class, // Tạo product images
            VariationSeeder::class,   // Tạo variations
            VariationImageSeeder::class, // Tạo variation images

            // 5. Seeder cho nội dung
            NewsSeeder::class,        // Tạo tin tức
            CommentSeeder::class,     // Tạo bình luận
            SliderSeeder::class,      // Tạo slider
            FaqSeeder::class,         // Tạo FAQ

            // 6. Seeder cho đơn hàng và thanh toán
            OrderSeeder::class,     // Tạo đơn hàng
            PaymentSeeder::class,   // Tạo thanh toán
        ]);
    }

    /**
     * Xóa dữ liệu cũ từ các bảng
     */
    private function cleanDatabase(): void
    {
        $tables = [
            'role_permission',
            'permissions',
            'roles',
            'users',
            'categories',
            'brands',
            'products',
            'product_images',
            'variations',
            'variation_images',
            'news',
            'comments',
            'sliders',
            'faqs',
            // 'orders',
            // 'payments',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}