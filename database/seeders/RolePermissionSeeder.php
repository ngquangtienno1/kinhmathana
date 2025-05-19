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
            ['name' => 'Xem danh sách người dùng', 'slug' => 'xem-danh-sach-nguoi-dung', 'description' => 'Cho phép xem danh sách người dùng'],
            ['name' => 'Thêm người dùng', 'slug' => 'them-nguoi-dung', 'description' => 'Cho phép thêm người dùng mới'],
            ['name' => 'Sửa người dùng', 'slug' => 'sua-nguoi-dung', 'description' => 'Cho phép chỉnh sửa thông tin người dùng'],
            ['name' => 'Xóa người dùng', 'slug' => 'xoa-nguoi-dung', 'description' => 'Cho phép xóa người dùng'],
            ['name' => 'Khóa/Mở khóa người dùng', 'slug' => 'khoa-mo-khoa-nguoi-dung', 'description' => 'Cho phép khóa hoặc mở khóa tài khoản người dùng'],

            // Quản lý vai trò
            ['name' => 'Xem danh sách vai trò', 'slug' => 'xem-danh-sach-vai-tro', 'description' => 'Cho phép xem danh sách vai trò'],
            ['name' => 'Thêm vai trò', 'slug' => 'them-vai-tro', 'description' => 'Cho phép thêm vai trò mới'],
            ['name' => 'Sửa vai trò', 'slug' => 'sua-vai-tro', 'description' => 'Cho phép chỉnh sửa vai trò'],
            ['name' => 'Xóa vai trò', 'slug' => 'xoa-vai-tro', 'description' => 'Cho phép xóa vai trò'],
            ['name' => 'Phân quyền vai trò', 'slug' => 'phan-quyen-vai-tro', 'description' => 'Cho phép phân quyền cho vai trò'],

            // Quản lý quyền
            ['name' => 'Xem danh sách quyền', 'slug' => 'xem-danh-sach-quyen', 'description' => 'Cho phép xem danh sách quyền'],
            ['name' => 'Thêm quyền', 'slug' => 'them-quyen', 'description' => 'Cho phép thêm quyền mới'],
            ['name' => 'Sửa quyền', 'slug' => 'sua-quyen', 'description' => 'Cho phép chỉnh sửa quyền'],
            ['name' => 'Xóa quyền', 'slug' => 'xoa-quyen', 'description' => 'Cho phép xóa quyền'],

            // Quản lý sản phẩm
            ['name' => 'Xem danh sách sản phẩm', 'slug' => 'xem-danh-sach-san-pham', 'description' => 'Cho phép xem danh sách sản phẩm'],
            ['name' => 'Thêm sản phẩm', 'slug' => 'them-san-pham', 'description' => 'Cho phép thêm sản phẩm mới'],
            ['name' => 'Sửa sản phẩm', 'slug' => 'sua-san-pham', 'description' => 'Cho phép chỉnh sửa sản phẩm'],
            ['name' => 'Xóa sản phẩm', 'slug' => 'xoa-san-pham', 'description' => 'Cho phép xóa sản phẩm'],
            ['name' => 'Nhập sản phẩm', 'slug' => 'nhap-san-pham', 'description' => 'Cho phép nhập sản phẩm từ file'],
            ['name' => 'Xuất sản phẩm', 'slug' => 'xuat-san-pham', 'description' => 'Cho phép xuất danh sách sản phẩm'],
            ['name' => 'Quản lý tồn kho', 'slug' => 'quan-ly-ton-kho', 'description' => 'Cho phép quản lý số lượng tồn kho'],

            // Quản lý danh mục
            ['name' => 'Xem danh sách danh mục', 'slug' => 'xem-danh-sach-danh-muc', 'description' => 'Cho phép xem danh sách danh mục'],
            ['name' => 'Thêm danh mục', 'slug' => 'them-danh-muc', 'description' => 'Cho phép thêm danh mục mới'],
            ['name' => 'Sửa danh mục', 'slug' => 'sua-danh-muc', 'description' => 'Cho phép chỉnh sửa danh mục'],
            ['name' => 'Xóa danh mục', 'slug' => 'xoa-danh-muc', 'description' => 'Cho phép xóa danh mục'],
            ['name' => 'Sắp xếp danh mục', 'slug' => 'sap-xep-danh-muc', 'description' => 'Cho phép sắp xếp thứ tự danh mục'],

            // Quản lý slider
            ['name' => 'Xem danh sách slider', 'slug' => 'xem-danh-sach-slider', 'description' => 'Cho phép xem danh sách slider'],
            ['name' => 'Thêm slider', 'slug' => 'them-slider', 'description' => 'Cho phép thêm slider mới'],
            ['name' => 'Sửa slider', 'slug' => 'sua-slider', 'description' => 'Cho phép chỉnh sửa slider'],
            ['name' => 'Xóa slider', 'slug' => 'xoa-slider', 'description' => 'Cho phép xóa slider'],
            ['name' => 'Sắp xếp slider', 'slug' => 'sap-xep-slider', 'description' => 'Cho phép sắp xếp thứ tự slider'],

            // Quản lý FAQ
            ['name' => 'Xem danh sách FAQ', 'slug' => 'xem-danh-sach-faq', 'description' => 'Cho phép xem danh sách FAQ'],
            ['name' => 'Thêm FAQ', 'slug' => 'them-faq', 'description' => 'Cho phép thêm FAQ mới'],
            ['name' => 'Sửa FAQ', 'slug' => 'sua-faq', 'description' => 'Cho phép chỉnh sửa FAQ'],
            ['name' => 'Xóa FAQ', 'slug' => 'xoa-faq', 'description' => 'Cho phép xóa FAQ'],
            ['name' => 'Sắp xếp FAQ', 'slug' => 'sap-xep-faq', 'description' => 'Cho phép sắp xếp thứ tự FAQ'],

            // Quản lý đơn hàng
            ['name' => 'Xem danh sách đơn hàng', 'slug' => 'xem-danh-sach-don-hang', 'description' => 'Cho phép xem danh sách đơn hàng'],
            ['name' => 'Xem chi tiết đơn hàng', 'slug' => 'xem-chi-tiet-don-hang', 'description' => 'Cho phép xem chi tiết đơn hàng'],
            ['name' => 'Cập nhật trạng thái đơn hàng', 'slug' => 'cap-nhat-trang-thai-don-hang', 'description' => 'Cho phép cập nhật trạng thái đơn hàng'],
            ['name' => 'Xóa đơn hàng', 'slug' => 'xoa-don-hang', 'description' => 'Cho phép xóa đơn hàng'],
            ['name' => 'Xuất đơn hàng', 'slug' => 'xuat-don-hang', 'description' => 'Cho phép xuất danh sách đơn hàng'],
            ['name' => 'In đơn hàng', 'slug' => 'in-don-hang', 'description' => 'Cho phép in đơn hàng'],

            // Quản lý khuyến mãi
            ['name' => 'Xem danh sách khuyến mãi', 'slug' => 'xem-danh-sach-khuyen-mai', 'description' => 'Cho phép xem danh sách khuyến mãi'],
            ['name' => 'Thêm khuyến mãi', 'slug' => 'them-khuyen-mai', 'description' => 'Cho phép thêm khuyến mãi mới'],
            ['name' => 'Sửa khuyến mãi', 'slug' => 'sua-khuyen-mai', 'description' => 'Cho phép chỉnh sửa khuyến mãi'],
            ['name' => 'Xóa khuyến mãi', 'slug' => 'xoa-khuyen-mai', 'description' => 'Cho phép xóa khuyến mãi'],

            // Quản lý mã giảm giá
            ['name' => 'Xem danh sách mã giảm giá', 'slug' => 'xem-danh-sach-ma-giam-gia', 'description' => 'Cho phép xem danh sách mã giảm giá'],
            ['name' => 'Thêm mã giảm giá', 'slug' => 'them-ma-giam-gia', 'description' => 'Cho phép thêm mã giảm giá mới'],
            ['name' => 'Sửa mã giảm giá', 'slug' => 'sua-ma-giam-gia', 'description' => 'Cho phép chỉnh sửa mã giảm giá'],
            ['name' => 'Xóa mã giảm giá', 'slug' => 'xoa-ma-giam-gia', 'description' => 'Cho phép xóa mã giảm giá'],

            // Quản lý báo cáo
            ['name' => 'Xem báo cáo doanh thu', 'slug' => 'xem-bao-cao-doanh-thu', 'description' => 'Cho phép xem báo cáo doanh thu'],
            ['name' => 'Xem báo cáo sản phẩm', 'slug' => 'xem-bao-cao-san-pham', 'description' => 'Cho phép xem báo cáo sản phẩm'],
            ['name' => 'Xem báo cáo đơn hàng', 'slug' => 'xem-bao-cao-don-hang', 'description' => 'Cho phép xem báo cáo đơn hàng'],
            ['name' => 'Xuất báo cáo', 'slug' => 'xuat-bao-cao', 'description' => 'Cho phép xuất báo cáo'],

            // Quản lý cài đặt
            ['name' => 'Xem cài đặt', 'slug' => 'xem-cai-dat', 'description' => 'Cho phép xem cài đặt hệ thống'],
            ['name' => 'Cập nhật cài đặt', 'slug' => 'cap-nhat-cai-dat', 'description' => 'Cho phép cập nhật cài đặt hệ thống'],
            ['name' => 'Quản lý menu', 'slug' => 'quan-ly-menu', 'description' => 'Cho phép quản lý menu hệ thống'],
            ['name' => 'Quản lý banner', 'slug' => 'quan-ly-banner', 'description' => 'Cho phép quản lý banner'],
            ['name' => 'Quản lý trang tĩnh', 'slug' => 'quan-ly-trang-tinh', 'description' => 'Cho phép quản lý các trang tĩnh'],
            ['name' => 'Quản lý liên hệ', 'slug' => 'quan-ly-lien-he', 'description' => 'Cho phép quản lý thông tin liên hệ'],
            ['name' => 'Quản lý SEO', 'slug' => 'quan-ly-seo', 'description' => 'Cho phép quản lý thông tin SEO'],
            ['name' => 'Quản lý backup', 'slug' => 'quan-ly-backup', 'description' => 'Cho phép quản lý sao lưu dữ liệu'],
            ['name' => 'Quản lý log', 'slug' => 'quan-ly-log', 'description' => 'Cho phép xem và quản lý log hệ thống'],

            // Quản lý vận chuyển
            ['name' => 'Xem đơn vị vận chuyển', 'slug' => 'xem-don-vi-van-chuyen', 'description' => 'Cho phép xem danh sách đơn vị vận chuyển'],
            ['name' => 'Thêm đơn vị vận chuyển', 'slug' => 'them-don-vi-van-chuyen', 'description' => 'Cho phép thêm đơn vị vận chuyển mới'],
            ['name' => 'Sửa đơn vị vận chuyển', 'slug' => 'sua-don-vi-van-chuyen', 'description' => 'Cho phép chỉnh sửa đơn vị vận chuyển'],
            ['name' => 'Xóa đơn vị vận chuyển', 'slug' => 'xoa-don-vi-van-chuyen', 'description' => 'Cho phép xóa đơn vị vận chuyển'],
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
            'xem-danh-sach-san-pham',
            'xem-danh-sach-don-hang',
            'cap-nhat-trang-thai-don-hang',
            'xoa-don-hang',
            'xem-danh-sach-faq',
            'xem-news',
            'xem-danh-sach-slider'
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
            'xem-danh-sach-san-pham',
            'xem-danh-sach-faq',
            'xem-news',
            'xem-danh-sach-slider'
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
