<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,        // Chạy trước để tạo roles
            UserSeeder::class,        // Sau đó tạo users với role_id
            NewsSeeder::class,        // Tạo tin tức
            ProductSeeder::class,     // Tạo sản phẩm
            CommentSeeder::class,     // Tạo bình luận
            RolePermissionSeeder::class, // Tạo role permission
            // Các seeder khác có thể thêm vào đây
            // OrderSeeder::class,
            // SliderSeeder::class,
            // BrandSeeder::class,
            // ShippingProviderSeeder::class,
            // WebsiteSettingSeeder::class,
        ]);
    }
}