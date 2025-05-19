<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Xóa dữ liệu cũ để tránh trùng lặp
        $this->cleanDatabase();

        // 2. Tạo roles
        $this->createRoles();

        // 3. Tạo permissions
        $this->createPermissions();

        // 4. Gán permissions cho roles
        $this->assignPermissionsToRoles();
    }

    /**
     * Xóa dữ liệu cũ từ các bảng
     */
    private function cleanDatabase(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('role_permission')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Tạo các roles cơ bản
     */
    private function createRoles(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Quản trị viên hệ thống',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nhân viên',
                'description' => 'Nhân viên quản lý',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Khách hàng',
                'description' => 'Khách hàng sử dụng hệ thống',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }

    /**
     * Tạo các permissions cho hệ thống
     */
    private function createPermissions(): void
    {
        $permissions = [
            // Quản lý người dùng
            ['name' => 'Xem danh sách người dùng', 'slug' => 'view-users', 'description' => 'Cho phép xem danh sách người dùng'],
            ['name' => 'Thêm người dùng', 'slug' => 'create-users', 'description' => 'Cho phép thêm người dùng mới'],
            ['name' => 'Sửa người dùng', 'slug' => 'edit-users', 'description' => 'Cho phép chỉnh sửa thông tin người dùng'],
            ['name' => 'Xóa người dùng', 'slug' => 'delete-users', 'description' => 'Cho phép xóa người dùng'],
            ['name' => 'Khóa/Mở khóa người dùng', 'slug' => 'toggle-users', 'description' => 'Cho phép khóa hoặc mở khóa tài khoản người dùng'],

            // Quản lý vai trò
            ['name' => 'Xem danh sách vai trò', 'slug' => 'view-roles', 'description' => 'Cho phép xem danh sách vai trò'],
            ['name' => 'Thêm vai trò', 'slug' => 'create-roles', 'description' => 'Cho phép thêm vai trò mới'],
            ['name' => 'Sửa vai trò', 'slug' => 'edit-roles', 'description' => 'Cho phép chỉnh sửa vai trò'],
            ['name' => 'Xóa vai trò', 'slug' => 'delete-roles', 'description' => 'Cho phép xóa vai trò'],
            ['name' => 'Phân quyền vai trò', 'slug' => 'assign-roles', 'description' => 'Cho phép phân quyền cho vai trò'],

            // Quản lý quyền
            ['name' => 'Xem danh sách quyền', 'slug' => 'view-permissions', 'description' => 'Cho phép xem danh sách quyền'],
            ['name' => 'Thêm quyền', 'slug' => 'create-permissions', 'description' => 'Cho phép thêm quyền mới'],
            ['name' => 'Sửa quyền', 'slug' => 'edit-permissions', 'description' => 'Cho phép chỉnh sửa quyền'],
            ['name' => 'Xóa quyền', 'slug' => 'delete-permissions', 'description' => 'Cho phép xóa quyền'],

            // Quản lý sản phẩm
            ['name' => 'Xem danh sách sản phẩm', 'slug' => 'view-products', 'description' => 'Cho phép xem danh sách sản phẩm'],
            ['name' => 'Thêm sản phẩm', 'slug' => 'create-products', 'description' => 'Cho phép thêm sản phẩm mới'],
            ['name' => 'Sửa sản phẩm', 'slug' => 'edit-products', 'description' => 'Cho phép chỉnh sửa sản phẩm'],
            ['name' => 'Xóa sản phẩm', 'slug' => 'delete-products', 'description' => 'Cho phép xóa sản phẩm'],
            ['name' => 'Nhập sản phẩm', 'slug' => 'import-products', 'description' => 'Cho phép nhập sản phẩm từ file'],
            ['name' => 'Xuất sản phẩm', 'slug' => 'export-products', 'description' => 'Cho phép xuất danh sách sản phẩm'],
            ['name' => 'Quản lý tồn kho', 'slug' => 'manage-inventory', 'description' => 'Cho phép quản lý số lượng tồn kho'],

            // Quản lý danh mục
            ['name' => 'Xem danh sách danh mục', 'slug' => 'view-categories', 'description' => 'Cho phép xem danh sách danh mục'],
            ['name' => 'Thêm danh mục', 'slug' => 'create-categories', 'description' => 'Cho phép thêm danh mục mới'],
            ['name' => 'Sửa danh mục', 'slug' => 'edit-categories', 'description' => 'Cho phép chỉnh sửa danh mục'],
            ['name' => 'Xóa danh mục', 'slug' => 'delete-categories', 'description' => 'Cho phép xóa danh mục'],
            ['name' => 'Sắp xếp danh mục', 'slug' => 'sort-categories', 'description' => 'Cho phép sắp xếp thứ tự danh mục'],

            // Quản lý slider
            ['name' => 'Xem danh sách slider', 'slug' => 'view-sliders', 'description' => 'Cho phép xem danh sách slider'],
            ['name' => 'Thêm slider', 'slug' => 'create-sliders', 'description' => 'Cho phép thêm slider mới'],
            ['name' => 'Sửa slider', 'slug' => 'edit-sliders', 'description' => 'Cho phép chỉnh sửa slider'],
            ['name' => 'Xóa slider', 'slug' => 'delete-sliders', 'description' => 'Cho phép xóa slider'],
            ['name' => 'Sắp xếp slider', 'slug' => 'sort-sliders', 'description' => 'Cho phép sắp xếp thứ tự slider'],

            // Quản lý FAQ
            ['name' => 'Xem danh sách FAQ', 'slug' => 'view-faqs', 'description' => 'Cho phép xem danh sách FAQ'],
            ['name' => 'Thêm FAQ', 'slug' => 'create-faqs', 'description' => 'Cho phép thêm FAQ mới'],
            ['name' => 'Sửa FAQ', 'slug' => 'edit-faqs', 'description' => 'Cho phép chỉnh sửa FAQ'],
            ['name' => 'Xóa FAQ', 'slug' => 'delete-faqs', 'description' => 'Cho phép xóa FAQ'],
            ['name' => 'Sắp xếp FAQ', 'slug' => 'sort-faqs', 'description' => 'Cho phép sắp xếp thứ tự FAQ'],

            // Quản lý đơn hàng
            ['name' => 'Xem danh sách đơn hàng', 'slug' => 'view-orders', 'description' => 'Cho phép xem danh sách đơn hàng'],
            ['name' => 'Xem chi tiết đơn hàng', 'slug' => 'view-order-details', 'description' => 'Cho phép xem chi tiết đơn hàng'],
            ['name' => 'Cập nhật trạng thái đơn hàng', 'slug' => 'update-orders', 'description' => 'Cho phép cập nhật trạng thái đơn hàng'],
            ['name' => 'Xóa đơn hàng', 'slug' => 'delete-orders', 'description' => 'Cho phép xóa đơn hàng'],
            ['name' => 'Xuất đơn hàng', 'slug' => 'export-orders', 'description' => 'Cho phép xuất danh sách đơn hàng'],
            ['name' => 'In đơn hàng', 'slug' => 'print-orders', 'description' => 'Cho phép in đơn hàng'],

            // Quản lý khuyến mãi
            ['name' => 'Xem danh sách khuyến mãi', 'slug' => 'view-promotions', 'description' => 'Cho phép xem danh sách khuyến mãi'],
            ['name' => 'Thêm khuyến mãi', 'slug' => 'create-promotions', 'description' => 'Cho phép thêm khuyến mãi mới'],
            ['name' => 'Sửa khuyến mãi', 'slug' => 'edit-promotions', 'description' => 'Cho phép chỉnh sửa khuyến mãi'],
            ['name' => 'Xóa khuyến mãi', 'slug' => 'delete-promotions', 'description' => 'Cho phép xóa khuyến mãi'],

            // Quản lý mã giảm giá
            ['name' => 'Xem danh sách mã giảm giá', 'slug' => 'view-coupons', 'description' => 'Cho phép xem danh sách mã giảm giá'],
            ['name' => 'Thêm mã giảm giá', 'slug' => 'create-coupons', 'description' => 'Cho phép thêm mã giảm giá mới'],
            ['name' => 'Sửa mã giảm giá', 'slug' => 'edit-coupons', 'description' => 'Cho phép chỉnh sửa mã giảm giá'],
            ['name' => 'Xóa mã giảm giá', 'slug' => 'delete-coupons', 'description' => 'Cho phép xóa mã giảm giá'],

            // Quản lý báo cáo
            ['name' => 'Xem báo cáo doanh thu', 'slug' => 'view-revenue-reports', 'description' => 'Cho phép xem báo cáo doanh thu'],
            ['name' => 'Xem báo cáo sản phẩm', 'slug' => 'view-product-reports', 'description' => 'Cho phép xem báo cáo sản phẩm'],
            ['name' => 'Xem báo cáo đơn hàng', 'slug' => 'view-order-reports', 'description' => 'Cho phép xem báo cáo đơn hàng'],
            ['name' => 'Xuất báo cáo', 'slug' => 'export-reports', 'description' => 'Cho phép xuất báo cáo'],

            // Quản lý cài đặt
            ['name' => 'Xem cài đặt', 'slug' => 'view-settings', 'description' => 'Cho phép xem cài đặt hệ thống'],
            ['name' => 'Cập nhật cài đặt', 'slug' => 'update-settings', 'description' => 'Cho phép cập nhật cài đặt hệ thống'],
            ['name' => 'Quản lý menu', 'slug' => 'manage-menus', 'description' => 'Cho phép quản lý menu hệ thống'],
            ['name' => 'Quản lý banner', 'slug' => 'manage-banners', 'description' => 'Cho phép quản lý banner'],
            ['name' => 'Quản lý trang tĩnh', 'slug' => 'manage-pages', 'description' => 'Cho phép quản lý các trang tĩnh'],
            ['name' => 'Quản lý liên hệ', 'slug' => 'manage-contacts', 'description' => 'Cho phép quản lý thông tin liên hệ'],
            ['name' => 'Quản lý SEO', 'slug' => 'manage-seo', 'description' => 'Cho phép quản lý thông tin SEO'],
            ['name' => 'Quản lý backup', 'slug' => 'manage-backups', 'description' => 'Cho phép quản lý sao lưu dữ liệu'],
            ['name' => 'Quản lý log', 'slug' => 'manage-logs', 'description' => 'Cho phép xem và quản lý log hệ thống'],

            // Quản lý vận chuyển
            ['name' => 'Xem đơn vị vận chuyển', 'slug' => 'view-shipping', 'description' => 'Cho phép xem danh sách đơn vị vận chuyển'],
            ['name' => 'Thêm đơn vị vận chuyển', 'slug' => 'create-shipping', 'description' => 'Cho phép thêm đơn vị vận chuyển mới'],
            ['name' => 'Sửa đơn vị vận chuyển', 'slug' => 'edit-shipping', 'description' => 'Cho phép chỉnh sửa đơn vị vận chuyển'],
            ['name' => 'Xóa đơn vị vận chuyển', 'slug' => 'delete-shipping', 'description' => 'Cho phép xóa đơn vị vận chuyển'],
        ];

        // Thêm timestamps cho mỗi permission
        foreach ($permissions as &$permission) {
            $permission['created_at'] = now();
            $permission['updated_at'] = now();
        }

        DB::table('permissions')->insert($permissions);
    }

    /**
     * Gán permissions cho các roles
     */
    private function assignPermissionsToRoles(): void
    {
        // Lấy tất cả permissions
        $allPermissions = DB::table('permissions')->get();
        $rolePermissions = [];

        // 1. Admin có tất cả quyền
        foreach ($allPermissions as $permission) {
            $rolePermissions[] = [
                'role_id' => 1, // Admin
                'permission_id' => $permission->id
            ];
        }

        // 2. Nhân viên có quyền xem và xử lý
        $staffPermissions = [
            'view-products',
            'view-orders',
            'update-orders',
            'delete-orders',
            'view-faqs',
            'view-news',
            'view-sliders'
        ];
        foreach ($allPermissions as $permission) {
            if (in_array($permission->slug, $staffPermissions)) {
                $rolePermissions[] = [
                    'role_id' => 2, // Nhân viên
                    'permission_id' => $permission->id
                ];
            }
        }

        // 3. Khách hàng chỉ có quyền xem
        $customerPermissions = [
            'view-products',
            'view-faqs',
            'view-news',
            'view-sliders'
        ];
        foreach ($allPermissions as $permission) {
            if (in_array($permission->slug, $customerPermissions)) {
                $rolePermissions[] = [
                    'role_id' => 3, // Khách hàng
                    'permission_id' => $permission->id
                ];
            }
        }

        DB::table('role_permission')->insert($rolePermissions);
    }
}