<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;

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
            CustomerSeeder::class,     // Tạo customers

            // 3. Seeder cho danh mục và thương hiệu
            CategorySeeder::class,    // Tạo categories
            BrandSeeder::class,       // Tạo brands

            // 4. Seeder cho các thuộc tính sản phẩm
            SphericalSeeder::class,   // Tạo spherical
            CylindricalSeeder::class, // Tạo cylindrical
            ColorSeeder::class,       // Tạo colors
            SizeSeeder::class,        // Tạo sizes

            // 5. Seeder cho sản phẩm và biến thể
            ProductSeeder::class,     // Tạo products
            ProductImageSeeder::class, // Tạo product images
            VariationSeeder::class,   // Tạo variations
            VariationImageSeeder::class, // Tạo variation images

            // 6. Seeder cho nội dung
            NewsSeeder::class,        // Tạo tin tức
            CommentSeeder::class,     // Tạo bình luận
            SliderSeeder::class,      // Tạo slider
            FaqSeeder::class,         // Tạo FAQ

            // 7. Seeder cho đơn hàng và thanh toán
            CancellationReasonSeeder::class,
            PromotionSeeder::class, // Tạo khuyến mãi
            PaymentMethodSeeder::class, // Tạo phương thức thanh toán
            ShippingProviderSeeder::class, // Tạo phương thức vận chuyển
            OrderSeeder::class,     // Tạo đơn hàng
            PaymentSeeder::class,   // Tạo thanh toán

            // 8. Seeder cho các bảng khác
            ReviewSeeder::class, // Tạo đánh giá
            CustomerSupportSeeder::class, // Tạo hỗ trợ khách hàng
            TicketSeeder::class, // Tạo ticket
            ContactMessageSeeder::class,
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
            'sphericals',
            'cylindricals',
            'colors',
            'sizes',
            'news',
            'comments',
            'sliders',
            'faqs',
            'promotions',
            'orders',
            'customers',
            'payment_methods',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }
}
