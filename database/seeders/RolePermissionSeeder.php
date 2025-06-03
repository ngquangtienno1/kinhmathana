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

            // Quản lý khách hàng
            ['name' => 'Xem danh sách khách hàng', 'slug' => 'xem-danh-sach-khach-hang', 'description' => 'Cho phép xem danh sách khách hàng'],
            ['name' => 'Xem chi tiết khách hàng', 'slug' => 'xem-chi-tiet-khach-hang', 'description' => 'Cho phép xem chi tiết khách hàng'],
            ['name' => 'Cập nhật thông tin khách hàng', 'slug' => 'cap-nhat-thong-tin-khach-hang', 'description' => 'Cho phép cập nhật thông tin khách hàng'],
            ['name' => 'Xóa khách hàng', 'slug' => 'xoa-khach-hang', 'description' => 'Cho phép xóa khách hàng'],
            ['name' => 'Sửa loại khách hàng', 'slug' => 'sua-loai-khach-hang', 'description' => 'Cho phép sửa loại khách hàng'],

            // Quản lý phương thức thanh toán
            ['name' => 'Xem danh sách phương thức thanh toán', 'slug' => 'xem-danh-sach-phuong-thuc-thanh-toan', 'description' => 'Cho phép xem danh sách phương thức thanh toán'],
            ['name' => 'Thêm phương thức thanh toán', 'slug' => 'them-phuong-thuc-thanh-toan', 'description' => 'Cho phép thêm phương thức thanh toán'],
            ['name' => 'Sửa phương thức thanh toán', 'slug' => 'sua-phuong-thuc-thanh-toan', 'description' => 'Cho phép chỉnh sửa phương thức thanh toán'],
            ['name' => 'Xóa phương thức thanh toán', 'slug' => 'xoa-phuong-thuc-thanh-toan', 'description' => 'Cho phép xóa phương thức thanh toán'],
            ['name' => 'Xoá nhiều phương thức thanh toán', 'slug' => 'xoa-nhieu-phuong-thuc-thanh-toan', 'description' => 'Cho phép xóa nhiều phương thức thanh toán cùng lúc'],
            // Quản lý ticket
            ['name' => 'Xem danh sách ticket', 'slug' => 'xem-ticket', 'description' => 'Cho phép xem danh sách ticket'],
            ['name' => 'Sửa ticket', 'slug' => 'sua-ticket', 'description' => 'Cho phép chỉnh sửa ticket'],
            ['name' => 'Xóa ticket', 'slug' => 'xoa-ticket', 'description' => 'Cho phép xóa ticket'],
            ['name' => 'Khôi phục ticket', 'slug' => 'khoi-phuc-ticket', 'description' => 'Cho phép khôi phục ticket đã xóa'],
            ['name' => 'Xóa vĩnh viễn ticket', 'slug' => 'xoa-vinh-vien-ticket', 'description' => 'Cho phép xóa vĩnh viễn ticket'],
            ['name' => 'Xem thùng rác ticket', 'slug' => 'xem-thung-rac-ticket', 'description' => 'Cho phép xem thùng rác ticket'],
            ['name' => 'Ẩn/Hiện ticket', 'slug' => 'an-hien-ticket', 'description' => 'Cho phép ẩn/hiện ticket'],

            // Quản lý người dùng
            ['name' => 'Xem danh sách người dùng', 'slug' => 'xem-danh-sach-nguoi-dung', 'description' => 'Cho phép xem danh sách người dùng'],
            ['name' => 'Thêm người dùng', 'slug' => 'them-nguoi-dung', 'description' => 'Cho phép thêm người dùng mới'],
            ['name' => 'Sửa người dùng', 'slug' => 'sua-nguoi-dung', 'description' => 'Cho phép chỉnh sửa thông tin người dùng'],
            ['name' => 'Xóa người dùng', 'slug' => 'xoa-nguoi-dung', 'description' => 'Cho phép xóa người dùng'],
            ['name' => 'Khóa/Mở khóa người dùng', 'slug' => 'khoa-mo-khoa-nguoi-dung', 'description' => 'Cho phép khóa hoặc mở khóa tài khoản người dùng'],
            ['name' => 'Khôi phục người dùng', 'slug' => 'khoi-phuc-nguoi-dung', 'description' => 'Cho phép khôi phục người dùng đã xóa'],
            ['name' => 'Xóa vĩnh viễn người dùng', 'slug' => 'xoa-vinh-vien-nguoi-dung', 'description' => 'Cho phép xóa vĩnh viễn người dùng'],

            // Quản lý vai trò
            ['name' => 'Xem danh sách vai trò', 'slug' => 'xem-danh-sach-vai-tro', 'description' => 'Cho phép xem danh sách vai trò'],
            ['name' => 'Thêm vai trò', 'slug' => 'them-vai-tro', 'description' => 'Cho phép thêm vai trò mới'],
            ['name' => 'Sửa vai trò', 'slug' => 'sua-vai-tro', 'description' => 'Cho phép chỉnh sửa vai trò'],
            ['name' => 'Xóa vai trò', 'slug' => 'xoa-vai-tro', 'description' => 'Cho phép xóa vai trò'],
            ['name' => 'Phân quyền vai trò', 'slug' => 'phan-quyen-vai-tro', 'description' => 'Cho phép phân quyền cho vai trò'],
            ['name' => 'Khôi phục vai trò', 'slug' => 'khoi-phuc-vai-tro', 'description' => 'Cho phép khôi phục vai trò đã xóa'],
            ['name' => 'Xóa vĩnh viễn vai trò', 'slug' => 'xoa-vinh-vien-vai-tro', 'description' => 'Cho phép xóa vĩnh viễn vai trò'],

            // Quản lý quyền
            ['name' => 'Xem danh sách quyền', 'slug' => 'xem-danh-sach-quyen', 'description' => 'Cho phép xem danh sách quyền'],
            ['name' => 'Thêm quyền', 'slug' => 'them-quyen', 'description' => 'Cho phép thêm quyền mới'],
            ['name' => 'Sửa quyền', 'slug' => 'sua-quyen', 'description' => 'Cho phép chỉnh sửa quyền'],
            ['name' => 'Xóa quyền', 'slug' => 'xoa-quyen', 'description' => 'Cho phép xóa quyền'],
            ['name' => 'Khôi phục quyền', 'slug' => 'khoi-phuc-quyen', 'description' => 'Cho phép khôi phục quyền đã xóa'],
            ['name' => 'Xóa vĩnh viễn quyền', 'slug' => 'xoa-vinh-vien-quyen', 'description' => 'Cho phép xóa vĩnh viễn quyền'],

            // Quản lý sản phẩm
            ['name' => 'Xem danh sách sản phẩm', 'slug' => 'xem-danh-sach-san-pham', 'description' => 'Cho phép xem danh sách sản phẩm'],
            ['name' => 'Thêm sản phẩm', 'slug' => 'them-san-pham', 'description' => 'Cho phép thêm sản phẩm mới'],
            ['name' => 'Sửa sản phẩm', 'slug' => 'sua-san-pham', 'description' => 'Cho phép chỉnh sửa sản phẩm'],
            ['name' => 'Xóa sản phẩm', 'slug' => 'xoa-san-pham', 'description' => 'Cho phép xóa sản phẩm'],
            ['name' => 'Khôi phục sản phẩm', 'slug' => 'khoi-phuc-san-pham', 'description' => 'Cho phép khôi phục sản phẩm đã xóa'],
            ['name' => 'Xóa vĩnh viễn sản phẩm', 'slug' => 'xoa-vinh-vien-san-pham', 'description' => 'Cho phép xóa vĩnh viễn sản phẩm'],
            ['name' => 'Xóa nhiều sản phẩm', 'slug' => 'xoa-nhieu-san-pham', 'description' => 'Cho phép xóa nhiều sản phẩm cùng lúc'],
            ['name' => 'Nhập sản phẩm', 'slug' => 'nhap-san-pham', 'description' => 'Cho phép nhập sản phẩm từ file'],
            ['name' => 'Xuất sản phẩm', 'slug' => 'xuat-san-pham', 'description' => 'Cho phép xuất danh sách sản phẩm'],
            ['name' => 'Quản lý tồn kho', 'slug' => 'quan-ly-ton-kho', 'description' => 'Cho phép quản lý số lượng tồn kho'],
            ['name' => 'Xem thùng rác sản phẩm', 'slug' => 'xem-thung-rac-san-pham', 'description' => 'Cho phép xem thùng rác sản phẩm'],

            // Quản lý danh mục
            ['name' => 'Xem danh sách danh mục', 'slug' => 'xem-danh-sach-danh-muc', 'description' => 'Cho phép xem danh sách danh mục'],
            ['name' => 'Thêm danh mục', 'slug' => 'them-danh-muc', 'description' => 'Cho phép thêm danh mục mới'],
            ['name' => 'Sửa danh mục', 'slug' => 'sua-danh-muc', 'description' => 'Cho phép chỉnh sửa danh mục'],
            ['name' => 'Xóa danh mục', 'slug' => 'xoa-danh-muc', 'description' => 'Cho phép xóa danh mục'],
            ['name' => 'Khôi phục danh mục', 'slug' => 'khoi-phuc-danh-muc', 'description' => 'Cho phép khôi phục danh mục đã xóa'],
            ['name' => 'Xóa vĩnh viễn danh mục', 'slug' => 'xoa-vinh-vien-danh-muc', 'description' => 'Cho phép xóa vĩnh viễn danh mục'],
            ['name' => 'Sắp xếp danh mục', 'slug' => 'sap-xep-danh-muc', 'description' => 'Cho phép sắp xếp thứ tự danh mục'],
            ['name' => 'Xem thùng rác danh mục', 'slug' => 'xem-thung-rac-danh-muc', 'description' => 'Cho phép xem thùng rác danh mục'],

            // Quản lý slider
            ['name' => 'Xem danh sách slider', 'slug' => 'xem-danh-sach-slider', 'description' => 'Cho phép xem danh sách slider'],
            ['name' => 'Thêm slider', 'slug' => 'them-slider', 'description' => 'Cho phép thêm slider mới'],
            ['name' => 'Sửa slider', 'slug' => 'sua-slider', 'description' => 'Cho phép chỉnh sửa slider'],
            ['name' => 'Xóa slider', 'slug' => 'xoa-slider', 'description' => 'Cho phép xóa slider'],
            ['name' => 'Khôi phục slider', 'slug' => 'khoi-phuc-slider', 'description' => 'Cho phép khôi phục slider đã xóa'],
            ['name' => 'Xóa vĩnh viễn slider', 'slug' => 'xoa-vinh-vien-slider', 'description' => 'Cho phép xóa vĩnh viễn slider'],
            ['name' => 'Xóa nhiều slider', 'slug' => 'xoa-nhieu-slider', 'description' => 'Cho phép xóa nhiều slider cùng lúc'],
            ['name' => 'Sắp xếp slider', 'slug' => 'sap-xep-slider', 'description' => 'Cho phép sắp xếp thứ tự slider'],
            ['name' => 'Xem thùng rác slider', 'slug' => 'xem-thung-rac-slider', 'description' => 'Cho phép xem thùng rác slider'],

            // Quản lý FAQ
            ['name' => 'Xem danh sách FAQ', 'slug' => 'xem-danh-sach-faq', 'description' => 'Cho phép xem danh sách FAQ'],
            ['name' => 'Thêm FAQ', 'slug' => 'them-faq', 'description' => 'Cho phép thêm FAQ mới'],
            ['name' => 'Sửa FAQ', 'slug' => 'sua-faq', 'description' => 'Cho phép chỉnh sửa FAQ'],
            ['name' => 'Xóa FAQ', 'slug' => 'xoa-faq', 'description' => 'Cho phép xóa FAQ'],
            ['name' => 'Xóa nhiều FAQ', 'slug' => 'xoa-nhieu-faq', 'description' => 'Cho phép xóa nhiều FAQ cùng lúc'],
            ['name' => 'Khôi phục FAQ', 'slug' => 'khoi-phuc-faq', 'description' => 'Cho phép khôi phục FAQ đã xóa'],
            ['name' => 'Xóa vĩnh viễn FAQ', 'slug' => 'xoa-vinh-vien-faq', 'description' => 'Cho phép xóa vĩnh viễn FAQ'],
            ['name' => 'Sắp xếp FAQ', 'slug' => 'sap-xep-faq', 'description' => 'Cho phép sắp xếp thứ tự FAQ'],
            ['name' => 'Xem thùng rác FAQ', 'slug' => 'xem-thung-rac-faq', 'description' => 'Cho phép xem thùng rác FAQ'],

            // Quản lý đơn hàng
            ['name' => 'Xem danh sách đơn hàng', 'slug' => 'xem-danh-sach-don-hang', 'description' => 'Cho phép xem danh sách đơn hàng'],
            ['name' => 'Xem chi tiết đơn hàng', 'slug' => 'xem-chi-tiet-don-hang', 'description' => 'Cho phép xem chi tiết đơn hàng'],
            ['name' => 'Cập nhật trạng thái đơn hàng', 'slug' => 'cap-nhat-trang-thai-don-hang', 'description' => 'Cho phép cập nhật trạng thái đơn hàng'],
            ['name' => 'Xóa đơn hàng', 'slug' => 'xoa-don-hang', 'description' => 'Cho phép xóa đơn hàng'],
            ['name' => 'Khôi phục đơn hàng', 'slug' => 'khoi-phuc-don-hang', 'description' => 'Cho phép khôi phục đơn hàng đã xóa'],
            ['name' => 'Xóa vĩnh viễn đơn hàng', 'slug' => 'xoa-vinh-vien-don-hang', 'description' => 'Cho phép xóa vĩnh viễn đơn hàng'],
            ['name' => 'Xuất đơn hàng', 'slug' => 'xuat-don-hang', 'description' => 'Cho phép xuất danh sách đơn hàng'],
            ['name' => 'In đơn hàng', 'slug' => 'in-don-hang', 'description' => 'Cho phép in đơn hàng'],
            ['name' => 'Xem thùng rác đơn hàng', 'slug' => 'xem-thung-rac-don-hang', 'description' => 'Cho phép xem thùng rác đơn hàng'],

            // Quản lý khuyến mãi
            ['name' => 'Xem danh sách khuyến mãi', 'slug' => 'xem-danh-sach-khuyen-mai', 'description' => 'Cho phép xem danh sách khuyến mãi'],
            ['name' => 'Thêm khuyến mãi', 'slug' => 'them-khuyen-mai', 'description' => 'Cho phép thêm khuyến mãi mới'],
            ['name' => 'Sửa khuyến mãi', 'slug' => 'sua-khuyen-mai', 'description' => 'Cho phép chỉnh sửa khuyến mãi'],
            ['name' => 'Xóa khuyến mãi', 'slug' => 'xoa-khuyen-mai', 'description' => 'Cho phép xóa khuyến mãi'],
            ['name' => 'Xóa nhiều khuyến mãi', 'slug' => 'xoa-nhieu-khuyen-mai', 'description' => 'Cho phép xóa nhiều khuyến mãi cùng lúc'],
            ['name' => 'Khôi phục khuyến mãi', 'slug' => 'khoi-phuc-khuyen-mai', 'description' => 'Cho phép khôi phục khuyến mãi đã xóa'],
            ['name' => 'Xóa vĩnh viễn khuyến mãi', 'slug' => 'xoa-vinh-vien-khuyen-mai', 'description' => 'Cho phép xóa vĩnh viễn khuyến mãi'],
            ['name' => 'Xem thùng rác khuyến mãi', 'slug' => 'xem-thung-rac-khuyen-mai', 'description' => 'Cho phép xem thùng rác khuyến mãi'],

            // Quản lý mã giảm giá
            ['name' => 'Xem danh sách mã giảm giá', 'slug' => 'xem-danh-sach-ma-giam-gia', 'description' => 'Cho phép xem danh sách mã giảm giá'],
            ['name' => 'Thêm mã giảm giá', 'slug' => 'them-ma-giam-gia', 'description' => 'Cho phép thêm mã giảm giá mới'],
            ['name' => 'Sửa mã giảm giá', 'slug' => 'sua-ma-giam-gia', 'description' => 'Cho phép chỉnh sửa mã giảm giá'],
            ['name' => 'Xóa mã giảm giá', 'slug' => 'xoa-ma-giam-gia', 'description' => 'Cho phép xóa mã giảm giá'],
            ['name' => 'Khôi phục mã giảm giá', 'slug' => 'khoi-phuc-ma-giam-gia', 'description' => 'Cho phép khôi phục mã giảm giá đã xóa'],
            ['name' => 'Xóa vĩnh viễn mã giảm giá', 'slug' => 'xoa-vinh-vien-ma-giam-gia', 'description' => 'Cho phép xóa vĩnh viễn mã giảm giá'],
            ['name' => 'Xem thùng rác mã giảm giá', 'slug' => 'xem-thung-rac-ma-giam-gia', 'description' => 'Cho phép xem thùng rác mã giảm giá'],

            // Quản lý báo cáo
            ['name' => 'Xem báo cáo doanh thu', 'slug' => 'xem-bao-cao-doanh-thu', 'description' => 'Cho phép xem báo cáo doanh thu'],
            ['name' => 'Xem báo cáo sản phẩm', 'slug' => 'xem-bao-cao-san-pham', 'description' => 'Cho phép xem báo cáo sản phẩm'],
            ['name' => 'Xem báo cáo đơn hàng', 'slug' => 'xem-bao-cao-don-hang', 'description' => 'Cho phép xem báo cáo đơn hàng'],
            ['name' => 'Xuất báo cáo', 'slug' => 'xuat-bao-cao', 'description' => 'Cho phép xuất báo cáo'],
            ['name' => 'Xem báo cáo tồn kho', 'slug' => 'xem-bao-cao-ton-kho', 'description' => 'Cho phép xem báo cáo tồn kho'],
            ['name' => 'Xem báo cáo khách hàng', 'slug' => 'xem-bao-cao-khach-hang', 'description' => 'Cho phép xem báo cáo khách hàng'],

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
            ['name' => 'Quản lý email', 'slug' => 'quan-ly-email', 'description' => 'Cho phép quản lý cấu hình email'],
            ['name' => 'Quản lý thanh toán', 'slug' => 'quan-ly-thanh-toan', 'description' => 'Cho phép quản lý cấu hình thanh toán'],
            ['name' => 'Quản lý vận chuyển', 'slug' => 'quan-ly-van-chuyen', 'description' => 'Cho phép quản lý cấu hình vận chuyển'],

            // Quản lý vận chuyển
            ['name' => 'Xem đơn vị vận chuyển', 'slug' => 'xem-don-vi-van-chuyen', 'description' => 'Cho phép xem danh sách đơn vị vận chuyển'],
            ['name' => 'Thêm đơn vị vận chuyển', 'slug' => 'them-don-vi-van-chuyen', 'description' => 'Cho phép thêm đơn vị vận chuyển mới'],
            ['name' => 'Sửa đơn vị vận chuyển', 'slug' => 'sua-don-vi-van-chuyen', 'description' => 'Cho phép chỉnh sửa đơn vị vận chuyển'],
            ['name' => 'Xóa đơn vị vận chuyển', 'slug' => 'xoa-don-vi-van-chuyen', 'description' => 'Cho phép xóa đơn vị vận chuyển'],
            ['name' => 'Khôi phục đơn vị vận chuyển', 'slug' => 'khoi-phuc-don-vi-van-chuyen', 'description' => 'Cho phép khôi phục đơn vị vận chuyển đã xóa'],
            ['name' => 'Xóa vĩnh viễn đơn vị vận chuyển', 'slug' => 'xoa-vinh-vien-don-vi-van-chuyen', 'description' => 'Cho phép xóa vĩnh viễn đơn vị vận chuyển'],
            ['name' => 'Xem thùng rác đơn vị vận chuyển', 'slug' => 'xem-thung-rac-don-vi-van-chuyen', 'description' => 'Cho phép xem thùng rác đơn vị vận chuyển'],

            // Quản lý thương hiệu
            ['name' => 'Xem danh sách thương hiệu', 'slug' => 'xem-danh-sach-thuong-hieu', 'description' => 'Cho phép xem danh sách thương hiệu'],
            ['name' => 'Thêm thương hiệu', 'slug' => 'them-thuong-hieu', 'description' => 'Cho phép thêm thương hiệu mới'],
            ['name' => 'Sửa thương hiệu', 'slug' => 'sua-thuong-hieu', 'description' => 'Cho phép chỉnh sửa thương hiệu'],
            ['name' => 'Xóa thương hiệu', 'slug' => 'xoa-thuong-hieu', 'description' => 'Cho phép xóa thương hiệu'],
            ['name' => 'Xóa nhiều thương hiệu', 'slug' => 'xoa-nhieu-thuong-hieu', 'description' => 'Cho phép xóa nhiều thương hiệu cùng lúc'],
            ['name' => 'Khôi phục thương hiệu', 'slug' => 'khoi-phuc-thuong-hieu', 'description' => 'Cho phép khôi phục thương hiệu đã xóa'],
            ['name' => 'Xóa vĩnh viễn thương hiệu', 'slug' => 'xoa-vinh-vien-thuong-hieu', 'description' => 'Cho phép xóa vĩnh viễn thương hiệu'],
            ['name' => 'Xem thùng rác thương hiệu', 'slug' => 'xem-thung-rac-thuong-hieu', 'description' => 'Cho phép xem thùng rác thương hiệu'],

            // Quản lý biến thể sản phẩm
            ['name' => 'Xem biến thể sản phẩm', 'slug' => 'xem-bien-the-san-pham', 'description' => 'Cho phép xem biến thể sản phẩm'],
            ['name' => 'Thêm biến thể sản phẩm', 'slug' => 'them-bien-the-san-pham', 'description' => 'Cho phép thêm biến thể sản phẩm mới'],
            ['name' => 'Sửa biến thể sản phẩm', 'slug' => 'sua-bien-the-san-pham', 'description' => 'Cho phép chỉnh sửa biến thể sản phẩm'],
            ['name' => 'Xóa biến thể sản phẩm', 'slug' => 'xoa-bien-the-san-pham', 'description' => 'Cho phép xóa biến thể sản phẩm'],
            ['name' => 'Khôi phục biến thể sản phẩm', 'slug' => 'khoi-phuc-bien-the-san-pham', 'description' => 'Cho phép khôi phục biến thể sản phẩm đã xóa'],
            ['name' => 'Xóa vĩnh viễn biến thể sản phẩm', 'slug' => 'xoa-vinh-vien-bien-the-san-pham', 'description' => 'Cho phép xóa vĩnh viễn biến thể sản phẩm'],
            ['name' => 'Xem thùng rác biến thể sản phẩm', 'slug' => 'xem-thung-rac-bien-the-san-pham', 'description' => 'Cho phép xem thùng rác biến thể sản phẩm'],

            // Quản lý ảnh sản phẩm
            ['name' => 'Xem ảnh sản phẩm', 'slug' => 'xem-anh-san-pham', 'description' => 'Cho phép xem ảnh sản phẩm'],
            ['name' => 'Thêm ảnh sản phẩm', 'slug' => 'them-anh-san-pham', 'description' => 'Cho phép thêm ảnh sản phẩm'],
            ['name' => 'Sửa ảnh sản phẩm', 'slug' => 'sua-anh-san-pham', 'description' => 'Cho phép sửa ảnh sản phẩm'],
            ['name' => 'Xóa ảnh sản phẩm', 'slug' => 'xoa-anh-san-pham', 'description' => 'Cho phép xóa ảnh sản phẩm'],
            ['name' => 'Đặt ảnh đại diện', 'slug' => 'dat-anh-dai-dien', 'description' => 'Cho phép đặt ảnh đại diện sản phẩm'],
            ['name' => 'Khôi phục ảnh sản phẩm', 'slug' => 'khoi-phuc-anh-san-pham', 'description' => 'Cho phép khôi phục ảnh sản phẩm đã xóa'],
            ['name' => 'Xóa vĩnh viễn ảnh sản phẩm', 'slug' => 'xoa-vinh-vien-anh-san-pham', 'description' => 'Cho phép xóa vĩnh viễn ảnh sản phẩm'],
            ['name' => 'Xem thùng rác ảnh sản phẩm', 'slug' => 'xem-thung-rac-anh-san-pham', 'description' => 'Cho phép xem thùng rác ảnh sản phẩm'],

            // Quản lý biến thể
            ['name' => 'Xem biến thể', 'slug' => 'xem-bien-the', 'description' => 'Cho phép xem biến thể sản phẩm'],
            ['name' => 'Thêm biến thể', 'slug' => 'them-bien-the', 'description' => 'Cho phép thêm biến thể mới'],
            ['name' => 'Sửa biến thể', 'slug' => 'sua-bien-the', 'description' => 'Cho phép sửa biến thể'],
            ['name' => 'Xóa biến thể', 'slug' => 'xoa-bien-the', 'description' => 'Cho phép xóa biến thể'],
            ['name' => 'Khôi phục biến thể', 'slug' => 'khoi-phuc-bien-the', 'description' => 'Cho phép khôi phục biến thể đã xóa'],
            ['name' => 'Xóa vĩnh viễn biến thể', 'slug' => 'xoa-vinh-vien-bien-the', 'description' => 'Cho phép xóa vĩnh viễn biến thể'],
            ['name' => 'Xem thùng rác biến thể', 'slug' => 'xem-thung-rac-bien-the', 'description' => 'Cho phép xem thùng rác biến thể'],

            // Quản lý ảnh biến thể
            ['name' => 'Xem ảnh biến thể', 'slug' => 'xem-anh-bien-the', 'description' => 'Cho phép xem ảnh biến thể'],
            ['name' => 'Thêm ảnh biến thể', 'slug' => 'them-anh-bien-the', 'description' => 'Cho phép thêm ảnh biến thể'],
            ['name' => 'Xóa ảnh biến thể', 'slug' => 'xoa-anh-bien-the', 'description' => 'Cho phép xóa ảnh biến thể'],
            ['name' => 'Đặt ảnh đại diện biến thể', 'slug' => 'dat-anh-dai-dien-bien-the', 'description' => 'Cho phép đặt ảnh đại diện biến thể'],
            ['name' => 'Khôi phục ảnh biến thể', 'slug' => 'khoi-phuc-anh-bien-the', 'description' => 'Cho phép khôi phục ảnh biến thể đã xóa'],
            ['name' => 'Xóa vĩnh viễn ảnh biến thể', 'slug' => 'xoa-vinh-vien-anh-bien-the', 'description' => 'Cho phép xóa vĩnh viễn ảnh biến thể'],
            ['name' => 'Xem thùng rác ảnh biến thể', 'slug' => 'xem-thung-rac-anh-bien-the', 'description' => 'Cho phép xem thùng rác ảnh biến thể'],

            // Quản lý màu sắc
            ['name' => 'Xem màu sắc', 'slug' => 'xem-mau-sac', 'description' => 'Cho phép xem danh sách màu sắc'],
            ['name' => 'Thêm màu sắc', 'slug' => 'them-mau-sac', 'description' => 'Cho phép thêm màu sắc mới'],
            ['name' => 'Sửa màu sắc', 'slug' => 'sua-mau-sac', 'description' => 'Cho phép sửa màu sắc'],
            ['name' => 'Xóa màu sắc', 'slug' => 'xoa-mau-sac', 'description' => 'Cho phép xóa màu sắc'],
            ['name' => 'Khôi phục màu sắc', 'slug' => 'khoi-phuc-mau-sac', 'description' => 'Cho phép khôi phục màu sắc đã xóa'],
            ['name' => 'Xóa vĩnh viễn màu sắc', 'slug' => 'xoa-vinh-vien-mau-sac', 'description' => 'Cho phép xóa vĩnh viễn màu sắc'],
            ['name' => 'Xem thùng rác màu sắc', 'slug' => 'xem-thung-rac-mau-sac', 'description' => 'Cho phép xem thùng rác màu sắc'],

            // Quản lý kích thước
            ['name' => 'Xem kích thước', 'slug' => 'xem-kich-thuoc', 'description' => 'Cho phép xem danh sách kích thước'],
            ['name' => 'Thêm kích thước', 'slug' => 'them-kich-thuoc', 'description' => 'Cho phép thêm kích thước mới'],
            ['name' => 'Sửa kích thước', 'slug' => 'sua-kich-thuoc', 'description' => 'Cho phép sửa kích thước'],
            ['name' => 'Xóa kích thước', 'slug' => 'xoa-kich-thuoc', 'description' => 'Cho phép xóa kích thước'],
            ['name' => 'Khôi phục kích thước', 'slug' => 'khoi-phuc-kich-thuoc', 'description' => 'Cho phép khôi phục kích thước đã xóa'],
            ['name' => 'Xóa vĩnh viễn kích thước', 'slug' => 'xoa-vinh-vien-kich-thuoc', 'description' => 'Cho phép xóa vĩnh viễn kích thước'],
            ['name' => 'Xem thùng rác kích thước', 'slug' => 'xem-thung-rac-kich-thuoc', 'description' => 'Cho phép xem thùng rác kích thước'],

            // Quản lý thanh toán
            ['name' => 'Xem thanh toán', 'slug' => 'xem-thanh-toan', 'description' => 'Cho phép xem danh sách thanh toán'],
            ['name' => 'Cập nhật trạng thái thanh toán', 'slug' => 'cap-nhat-trang-thai-thanh-toan', 'description' => 'Cho phép cập nhật trạng thái thanh toán'],
            ['name' => 'In hóa đơn', 'slug' => 'in-hoa-don', 'description' => 'Cho phép in hóa đơn thanh toán'],
            ['name' => 'Xóa thanh toán', 'slug' => 'xoa-thanh-toan', 'description' => 'Cho phép xóa thanh toán'],
            ['name' => 'Khôi phục thanh toán', 'slug' => 'khoi-phuc-thanh-toan', 'description' => 'Cho phép khôi phục thanh toán đã xóa'],
            ['name' => 'Xóa vĩnh viễn thanh toán', 'slug' => 'xoa-vinh-vien-thanh-toan', 'description' => 'Cho phép xóa vĩnh viễn thanh toán'],
            ['name' => 'Xem thùng rác thanh toán', 'slug' => 'xem-thung-rac-thanh-toan', 'description' => 'Cho phép xem thùng rác thanh toán'],

            // Quản lý bình luận
            ['name' => 'Xem bình luận', 'slug' => 'xem-binh-luan', 'description' => 'Cho phép xem danh sách bình luận'],
            ['name' => 'Thêm bình luận', 'slug' => 'them-binh-luan', 'description' => 'Cho phép thêm bình luận mới'],
            ['name' => 'Sửa bình luận', 'slug' => 'sua-binh-luan', 'description' => 'Cho phép sửa bình luận'],
            ['name' => 'Xóa bình luận', 'slug' => 'xoa-binh-luan', 'description' => 'Cho phép xóa bình luận'],
            ['name' => 'Khôi phục bình luận', 'slug' => 'khoi-phuc-binh-luan', 'description' => 'Cho phép khôi phục bình luận đã xóa'],
            ['name' => 'Xóa vĩnh viễn bình luận', 'slug' => 'xoa-vinh-vien-binh-luan', 'description' => 'Cho phép xóa vĩnh viễn bình luận'],
            ['name' => 'Ẩn/Hiện bình luận', 'slug' => 'an-hien-binh-luan', 'description' => 'Cho phép ẩn/hiện bình luận'],
            ['name' => 'Xem thùng rác bình luận', 'slug' => 'xem-thung-rac-binh-luan', 'description' => 'Cho phép xem thùng rác bình luận'],

            // Quản lý tin tức
            ['name' => 'Xem tin tức', 'slug' => 'xem-news', 'description' => 'Cho phép xem danh sách tin tức'],
            ['name' => 'Thêm tin tức', 'slug' => 'them-news', 'description' => 'Cho phép thêm tin tức mới'],
            ['name' => 'Sửa tin tức', 'slug' => 'sua-news', 'description' => 'Cho phép chỉnh sửa tin tức'],
            ['name' => 'Xóa tin tức', 'slug' => 'xoa-news', 'description' => 'Cho phép xóa tin tức'],
            ['name' => 'Xóa nhiều tin tức', 'slug' => 'xoa-nhieu-news', 'description' => 'Cho phép xóa nhiều tin tức cùng lúc'],
            ['name' => 'Khôi phục tin tức', 'slug' => 'khoi-phuc-news', 'description' => 'Cho phép khôi phục tin tức đã xóa'],
            ['name' => 'Xóa vĩnh viễn tin tức', 'slug' => 'xoa-vinh-vien-news', 'description' => 'Cho phép xóa vĩnh viễn tin tức'],
            ['name' => 'Xem thùng rác tin tức', 'slug' => 'xem-thung-rac-news', 'description' => 'Cho phép xem thùng rác tin tức'],

            //Quản lý danh mục tin tức
            ['name' => 'Xem danh mục tin tức', 'slug' => 'xem-danh-muc-tin-tuc', 'description' => 'Cho phép xem danh mục tin tức'],
            ['name' => 'Thêm danh mục tin tức', 'slug' => 'them-danh-muc-tin-tuc', 'description' => 'Cho phép thêm danh mục tin tức'],
            ['name' => 'Sửa danh mục tin tức', 'slug' => 'sua-danh-muc-tin-tuc', 'description' => 'Cho phép chỉnh sửa danh mục tin tức'],
            ['name' => 'Xóa danh mục tin tức', 'slug' => 'xoa-danh-muc-tin-tuc', 'description' => 'Cho phép xóa danh mục tin tức'],
            ['name' => 'Xóa nhiều danh mục tin tức', 'slug' => 'xoa-nhieu-danh-muc-tin-tuc', 'description' => 'Cho phép xóa nhiều danh mục tin tức cùng lúc'],
            ['name' => 'Khôi phục danh mục tin tức', 'slug' => 'khoi-phuc-danh-muc-tin-tuc', 'description' => 'Cho phép khôi phục danh mục tin tức đã xóa'],
            ['name' => 'Xóa vĩnh viễn danh mục tin tức', 'slug' => 'xoa-vinh-vien-danh-muc-tin-tuc', 'description' => 'Cho phép xóa vĩnh viễn danh mục tin tức'],
            ['name' => 'Xem thùng rác danh mục tin tức', 'slug' => 'xem-thung-rac-danh-muc-tin-tuc', 'description' => 'Cho phép xem thùng rác danh mục tin tức'],

            //Quản lý lý do huỷ đơn
            ['name' => 'Xem lý do huỷ đơn', 'slug' => 'xem-ly-do-huy-don', 'description' => 'Cho phép xem danh sách lý do huỷ đơn'],
            ['name' => 'Thêm lý do huỷ đơn', 'slug' => 'them-ly-do-huy-don', 'description' => 'Cho phép thêm lý do huỷ đơn'],
            ['name' => 'Sửa lý do huỷ đơn', 'slug' => 'sua-ly-do-huy-don', 'description' => 'Cho phép chỉnh sửa lý do huỷ đơn'],
            ['name' => 'Xóa lý do huỷ đơn', 'slug' => 'xoa-ly-do-huy-don', 'description' => 'Cho phép xóa lý do huỷ đơn'],
            ['name' => 'Xóa nhiều lý do huỷ đơn', 'slug' => 'xoa-nhieu-ly-do-huy-don', 'description' => 'Cho phép xóa nhiều lý do huỷ đơn cùng lúc'],
            ['name' => 'Khôi phục lý do huỷ đơn', 'slug' => 'khoi-phuc-ly-do-huy-don', 'description' => 'Cho phép khôi phục lý do huỷ đơn đã xóa'],
            ['name' => 'Xóa vĩnh viễn lý do huỷ đơn', 'slug' => 'xoa-vinh-vien-ly-do-huy-don', 'description' => 'Cho phép xóa vĩnh viễn lý do huỷ đơn'],
            ['name' => 'Xem thùng rác lý do huỷ đơn', 'slug' => 'xem-thung-rac-ly-do-huy-don', 'description' => 'Cho phép xem thùng rác tin tức'],

            //Quản lý đánh giá
            ['name' => 'Xem danh sách đánh giá', 'slug' => 'xem-danh-sach-danh-gia', 'description' => 'Cho phép xem danh sách đánh giá'],
            ['name' => 'Xóa đánh giá', 'slug' => 'xoa-danh-gia', 'description' => 'Cho phép xóa đánh giá'],
            ['name' => 'Xóa nhiều đánh giá', 'slug' => 'xoa-nhieu-danh-gia', 'description' => 'Cho phép xóa nhiều đánh giá cùng lúc'],

            // Quản lý dashboard
            ['name' => 'Xem dashboard', 'slug' => 'xem-dashboard', 'description' => 'Cho phép xem trang dashboard'],
            ['name' => 'Xem thống kê', 'slug' => 'xem-thong-ke', 'description' => 'Cho phép xem thống kê hệ thống'],
            ['name' => 'Xem biểu đồ', 'slug' => 'xem-bieu-do', 'description' => 'Cho phép xem biểu đồ thống kê'],
            ['name' => 'Xuất báo cáo dashboard', 'slug' => 'xuat-bao-cao-dashboard', 'description' => 'Cho phép xuất báo cáo từ dashboard'],

            // Quản lý hỗ trợ khách hàng
            ['name' => 'Xem danh sách hỗ trợ khách hàng', 'slug' => 'xem-danh-sach-ho-tro-khach-hang', 'description' => 'Cho phép xem danh sách hỗ trợ khách hàng'],
            ['name' => 'Thêm hỗ trợ khách hàng', 'slug' => 'them-ho-tro-khach-hang', 'description' => 'Cho phép thêm hỗ trợ khách hàng'],
            ['name' => 'Sửa hỗ trợ khách hàng', 'slug' => 'sua-ho-tro-khach-hang', 'description' => 'Cho phép sửa hỗ trợ khách hàng'],
            ['name' => 'Xóa hỗ trợ khách hàng', 'slug' => 'xoa-ho-tro-khach-hang', 'description' => 'Cho phép xóa hỗ trợ khách hàng'],
            ['name' => 'Khôi phục hỗ trợ khách hàng', 'slug' => 'khoi-phuc-ho-tro-khach-hang', 'description' => 'Cho phép khôi phục hỗ trợ khách hàng đã xóa'],
            ['name' => 'Xóa vĩnh viễn hỗ trợ khách hàng', 'slug' => 'xoa-vinh-vien-ho-tro-khach-hang', 'description' => 'Cho phép xóa vĩnh viễn hỗ trợ khách hàng'],

            // Quản lý thông báo
            ['name' => 'Xem danh sách thông báo', 'slug' => 'xem-danh-sach-thong-bao', 'description' => 'Cho phép xem danh sách thông báo'],
            ['name' => 'Thêm thông báo', 'slug' => 'them-thong-bao', 'description' => 'Cho phép thêm thông báo'],
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
            'xem-danh-sach-slider',
            'xem-binh-luan',
            'duyet-binh-luan',
            'xoa-binh-luan',
            'xem-danh-sach-thuong-hieu',
            'xem-bien-the-san-pham',
            'view-orders',
            'xem-thanh-toan',
            'cap-nhat-trang-thai-thanh-toan',
            'in-hoa-don',
            'xem-mau-sac',
            'xem-kich-thuoc',
            'xem-anh-san-pham',
            'xem-anh-bien-the'
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
            'xem-danh-sach-slider',
            'xem-danh-sach-thuong-hieu',
            'xem-bien-the-san-pham'
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