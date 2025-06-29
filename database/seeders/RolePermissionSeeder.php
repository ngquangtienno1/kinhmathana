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
            ['name' => 'Xem danh sách khách hàng', 'slug' => 'xem-danh-sach-khach-hang', 'description' => 'Cho phép xem danh sách khách hàng', 'group_permissions' => 'Khách hàng'],
            ['name' => 'Xem chi tiết khách hàng', 'slug' => 'xem-chi-tiet-khach-hang', 'description' => 'Cho phép xem chi tiết khách hàng', 'group_permissions' => 'Khách hàng'],
            ['name' => 'Cập nhật thông tin khách hàng', 'slug' => 'cap-nhat-thong-tin-khach-hang', 'description' => 'Cho phép cập nhật thông tin khách hàng', 'group_permissions' => 'Khách hàng'],
            ['name' => 'Xóa khách hàng', 'slug' => 'xoa-khach-hang', 'description' => 'Cho phép xóa khách hàng', 'group_permissions' => 'Khách hàng'],
            ['name' => 'Sửa loại khách hàng', 'slug' => 'sua-loai-khach-hang', 'description' => 'Cho phép sửa loại khách hàng', 'group_permissions' => 'Khách hàng'],

            // Quản lý phương thức thanh toán
            ['name' => 'Xem danh sách phương thức thanh toán', 'slug' => 'xem-danh-sach-phuong-thuc-thanh-toan', 'description' => 'Cho phép xem danh sách phương thức thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Thêm phương thức thanh toán', 'slug' => 'them-phuong-thuc-thanh-toan', 'description' => 'Cho phép thêm phương thức thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Sửa phương thức thanh toán', 'slug' => 'sua-phuong-thuc-thanh-toan', 'description' => 'Cho phép chỉnh sửa phương thức thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Xóa phương thức thanh toán', 'slug' => 'xoa-phuong-thuc-thanh-toan', 'description' => 'Cho phép xóa phương thức thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Xóa nhiều phương thức thanh toán', 'slug' => 'xoa-nhieu-phuong-thuc-thanh-toan', 'description' => 'Cho phép xóa nhiều phương thức thanh toán cùng lúc', 'group_permissions' => 'Thanh toán'],

            // Quản lý ticket
            ['name' => 'Xem danh sách ticket', 'slug' => 'xem-ticket', 'description' => 'Cho phép xem danh sách ticket', 'group_permissions' => 'Ticket'],
            ['name' => 'Sửa ticket', 'slug' => 'sua-ticket', 'description' => 'Cho phép chỉnh sửa ticket', 'group_permissions' => 'Ticket'],
            ['name' => 'Xóa ticket', 'slug' => 'xoa-ticket', 'description' => 'Cho phép xóa ticket', 'group_permissions' => 'Ticket'],
            ['name' => 'Khôi phục ticket', 'slug' => 'khoi-phuc-ticket', 'description' => 'Cho phép khôi phục ticket đã xóa', 'group_permissions' => 'Ticket'],
            ['name' => 'Xóa vĩnh viễn ticket', 'slug' => 'xoa-vinh-vien-ticket', 'description' => 'Cho phép xóa vĩnh viễn ticket', 'group_permissions' => 'Ticket'],
            ['name' => 'Xem thùng rác ticket', 'slug' => 'xem-thung-rac-ticket', 'description' => 'Cho phép xem thùng rác ticket', 'group_permissions' => 'Ticket'],
            ['name' => 'Ẩn/Hiện ticket', 'slug' => 'an-hien-ticket', 'description' => 'Cho phép ẩn/hiện ticket', 'group_permissions' => 'Ticket'],

            // Quản lý người dùng
            ['name' => 'Xem danh sách người dùng', 'slug' => 'xem-danh-sach-nguoi-dung', 'description' => 'Cho phép xem danh sách người dùng', 'group_permissions' => 'Người dùng'],
            ['name' => 'Thêm người dùng', 'slug' => 'them-nguoi-dung', 'description' => 'Cho phép thêm người dùng mới', 'group_permissions' => 'Người dùng'],
            ['name' => 'Sửa người dùng', 'slug' => 'sua-nguoi-dung', 'description' => 'Cho phép chỉnh sửa thông tin người dùng', 'group_permissions' => 'Người dùng'],
            ['name' => 'Xóa người dùng', 'slug' => 'xoa-nguoi-dung', 'description' => 'Cho phép xóa người dùng', 'group_permissions' => 'Người dùng'],
            ['name' => 'Khóa/Mở khóa người dùng', 'slug' => 'khoa-mo-khoa-nguoi-dung', 'description' => 'Cho phép khóa hoặc mở khóa tài khoản người dùng', 'group_permissions' => 'Người dùng'],
            ['name' => 'Khôi phục người dùng', 'slug' => 'khoi-phuc-nguoi-dung', 'description' => 'Cho phép khôi phục người dùng đã xóa', 'group_permissions' => 'Người dùng'],
            ['name' => 'Xóa vĩnh viễn người dùng', 'slug' => 'xoa-vinh-vien-nguoi-dung', 'description' => 'Cho phép xóa vĩnh viễn người dùng', 'group_permissions' => 'Người dùng'],

            // Quản lý vai trò
            ['name' => 'Xem danh sách vai trò', 'slug' => 'xem-danh-sach-vai-tro', 'description' => 'Cho phép xem danh sách vai trò', 'group_permissions' => 'Vai trò'],
            ['name' => 'Thêm vai trò', 'slug' => 'them-vai-tro', 'description' => 'Cho phép thêm vai trò mới', 'group_permissions' => 'Vai trò'],
            ['name' => 'Sửa vai trò', 'slug' => 'sua-vai-tro', 'description' => 'Cho phép chỉnh sửa vai trò', 'group_permissions' => 'Vai trò'],
            ['name' => 'Xóa vai trò', 'slug' => 'xoa-vai-tro', 'description' => 'Cho phép xóa vai trò', 'group_permissions' => 'Vai trò'],
            ['name' => 'Phân quyền vai trò', 'slug' => 'phan-quyen-vai-tro', 'description' => 'Cho phép phân quyền cho vai trò', 'group_permissions' => 'Vai trò'],
            ['name' => 'Khôi phục vai trò', 'slug' => 'khoi-phuc-vai-tro', 'description' => 'Cho phép khôi phục vai trò đã xóa', 'group_permissions' => 'Vai trò'],
            ['name' => 'Xóa vĩnh viễn vai trò', 'slug' => 'xoa-vinh-vien-vai-tro', 'description' => 'Cho phép xóa vĩnh viễn vai trò', 'group_permissions' => 'Vai trò'],

            // Quản lý quyền
            ['name' => 'Xem danh sách quyền', 'slug' => 'xem-danh-sach-quyen', 'description' => 'Cho phép xem danh sách quyền', 'group_permissions' => 'Quyền'],
            ['name' => 'Thêm quyền', 'slug' => 'them-quyen', 'description' => 'Cho phép thêm quyền mới', 'group_permissions' => 'Quyền'],
            ['name' => 'Sửa quyền', 'slug' => 'sua-quyen', 'description' => 'Cho phép chỉnh sửa quyền', 'group_permissions' => 'Quyền'],
            ['name' => 'Xóa quyền', 'slug' => 'xoa-quyen', 'description' => 'Cho phép xóa quyền', 'group_permissions' => 'Quyền'],
            ['name' => 'Khôi phục quyền', 'slug' => 'khoi-phuc-quyen', 'description' => 'Cho phép khôi phục quyền đã xóa', 'group_permissions' => 'Quyền'],
            ['name' => 'Xóa vĩnh viễn quyền', 'slug' => 'xoa-vinh-vien-quyen', 'description' => 'Cho phép xóa vĩnh viễn quyền', 'group_permissions' => 'Quyền'],

            // Quản lý sản phẩm
            ['name' => 'Xem danh sách sản phẩm', 'slug' => 'xem-danh-sach-san-pham', 'description' => 'Cho phép xem danh sách sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Thêm sản phẩm', 'slug' => 'them-san-pham', 'description' => 'Cho phép thêm sản phẩm mới', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Sửa sản phẩm', 'slug' => 'sua-san-pham', 'description' => 'Cho phép chỉnh sửa sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa sản phẩm', 'slug' => 'xoa-san-pham', 'description' => 'Cho phép xóa sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Khôi phục sản phẩm', 'slug' => 'khoi-phuc-san-pham', 'description' => 'Cho phép khôi phục sản phẩm đã xóa', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa vĩnh viễn sản phẩm', 'slug' => 'xoa-vinh-vien-san-pham', 'description' => 'Cho phép xóa vĩnh viễn sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa nhiều sản phẩm', 'slug' => 'xoa-nhieu-san-pham', 'description' => 'Cho phép xóa nhiều sản phẩm cùng lúc', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Nhập sản phẩm', 'slug' => 'nhap-san-pham', 'description' => 'Cho phép nhập sản phẩm từ file', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xuất sản phẩm', 'slug' => 'xuat-san-pham', 'description' => 'Cho phép xuất danh sách sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Quản lý tồn kho', 'slug' => 'quan-ly-ton-kho', 'description' => 'Cho phép quản lý số lượng tồn kho', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xem thùng rác sản phẩm', 'slug' => 'xem-thung-rac-san-pham', 'description' => 'Cho phép xem thùng rác sản phẩm', 'group_permissions' => 'Sản phẩm'],

            // Quản lý danh mục
            ['name' => 'Xem danh sách danh mục', 'slug' => 'xem-danh-sach-danh-muc', 'description' => 'Cho phép xem danh sách danh mục', 'group_permissions' => 'Danh mục'],
            ['name' => 'Thêm danh mục', 'slug' => 'them-danh-muc', 'description' => 'Cho phép thêm danh mục mới', 'group_permissions' => 'Danh mục'],
            ['name' => 'Sửa danh mục', 'slug' => 'sua-danh-muc', 'description' => 'Cho phép chỉnh sửa danh mục', 'group_permissions' => 'Danh mục'],
            ['name' => 'Xóa danh mục', 'slug' => 'xoa-danh-muc', 'description' => 'Cho phép xóa danh mục', 'group_permissions' => 'Danh mục'],
            ['name' => 'Khôi phục danh mục', 'slug' => 'khoi-phuc-danh-muc', 'description' => 'Cho phép khôi phục danh mục đã xóa', 'group_permissions' => 'Danh mục'],
            ['name' => 'Xóa vĩnh viễn danh mục', 'slug' => 'xoa-vinh-vien-danh-muc', 'description' => 'Cho phép xóa vĩnh viễn danh mục', 'group_permissions' => 'Danh mục'],
            ['name' => 'Sắp xếp danh mục', 'slug' => 'sap-xep-danh-muc', 'description' => 'Cho phép sắp xếp thứ tự danh mục', 'group_permissions' => 'Danh mục'],
            ['name' => 'Xem thùng rác danh mục', 'slug' => 'xem-thung-rac-danh-muc', 'description' => 'Cho phép xem thùng rác danh mục', 'group_permissions' => 'Danh mục'],

            // Quản lý slider
            ['name' => 'Xem danh sách slider', 'slug' => 'xem-danh-sach-slider', 'description' => 'Cho phép xem danh sách slider', 'group_permissions' => 'Slider'],
            ['name' => 'Thêm slider', 'slug' => 'them-slider', 'description' => 'Cho phép thêm slider mới', 'group_permissions' => 'Slider'],
            ['name' => 'Sửa slider', 'slug' => 'sua-slider', 'description' => 'Cho phép chỉnh sửa slider', 'group_permissions' => 'Slider'],
            ['name' => 'Xóa slider', 'slug' => 'xoa-slider', 'description' => 'Cho phép xóa slider', 'group_permissions' => 'Slider'],
            ['name' => 'Khôi phục slider', 'slug' => 'khoi-phuc-slider', 'description' => 'Cho phép khôi phục slider đã xóa', 'group_permissions' => 'Slider'],
            ['name' => 'Xóa vĩnh viễn slider', 'slug' => 'xoa-vinh-vien-slider', 'description' => 'Cho phép xóa vĩnh viễn slider', 'group_permissions' => 'Slider'],
            ['name' => 'Xóa nhiều slider', 'slug' => 'xoa-nhieu-slider', 'description' => 'Cho phép xóa nhiều slider cùng lúc', 'group_permissions' => 'Slider'],
            ['name' => 'Sắp xếp slider', 'slug' => 'sap-xep-slider', 'description' => 'Cho phép sắp xếp thứ tự slider', 'group_permissions' => 'Slider'],
            ['name' => 'Xem thùng rác slider', 'slug' => 'xem-thung-rac-slider', 'description' => 'Cho phép xem thùng rác slider', 'group_permissions' => 'Slider'],

            // Quản lý FAQ
            ['name' => 'Xem danh sách FAQ', 'slug' => 'xem-danh-sach-faq', 'description' => 'Cho phép xem danh sách FAQ', 'group_permissions' => 'FAQ'],
            ['name' => 'Thêm FAQ', 'slug' => 'them-faq', 'description' => 'Cho phép thêm FAQ mới', 'group_permissions' => 'FAQ'],
            ['name' => 'Sửa FAQ', 'slug' => 'sua-faq', 'description' => 'Cho phép chỉnh sửa FAQ', 'group_permissions' => 'FAQ'],
            ['name' => 'Xóa FAQ', 'slug' => 'xoa-faq', 'description' => 'Cho phép xóa FAQ', 'group_permissions' => 'FAQ'],
            ['name' => 'Xóa nhiều FAQ', 'slug' => 'xoa-nhieu-faq', 'description' => 'Cho phép xóa nhiều FAQ cùng lúc', 'group_permissions' => 'FAQ'],
            ['name' => 'Khôi phục FAQ', 'slug' => 'khoi-phuc-faq', 'description' => 'Cho phép khôi phục FAQ đã xóa', 'group_permissions' => 'FAQ'],
            ['name' => 'Xóa vĩnh viễn FAQ', 'slug' => 'xoa-vinh-vien-faq', 'description' => 'Cho phép xóa vĩnh viễn FAQ', 'group_permissions' => 'FAQ'],
            ['name' => 'Sắp xếp FAQ', 'slug' => 'sap-xep-faq', 'description' => 'Cho phép sắp xếp thứ tự FAQ', 'group_permissions' => 'FAQ'],
            ['name' => 'Xem thùng rác FAQ', 'slug' => 'xem-thung-rac-faq', 'description' => 'Cho phép xem thùng rác FAQ', 'group_permissions' => 'FAQ'],

            // Quản lý đơn hàng
            ['name' => 'Xem danh sách đơn hàng', 'slug' => 'xem-danh-sach-don-hang', 'description' => 'Cho phép xem danh sách đơn hàng', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xem chi tiết đơn hàng', 'slug' => 'xem-chi-tiet-don-hang', 'description' => 'Cho phép xem chi tiết đơn hàng', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Cập nhật trạng thái đơn hàng', 'slug' => 'cap-nhat-trang-thai-don-hang', 'description' => 'Cho phép cập nhật trạng thái đơn hàng', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xóa đơn hàng', 'slug' => 'xoa-don-hang', 'description' => 'Cho phép xóa đơn hàng', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Khôi phục đơn hàng', 'slug' => 'khoi-phuc-don-hang', 'description' => 'Cho phép khôi phục đơn hàng đã xóa', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xóa vĩnh viễn đơn hàng', 'slug' => 'xoa-vinh-vien-don-hang', 'description' => 'Cho phép xóa vĩnh viễn đơn hàng', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xuất đơn hàng', 'slug' => 'xuat-don-hang', 'description' => 'Cho phép xuất danh sách đơn hàng', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'In đơn hàng', 'slug' => 'in-don-hang', 'description' => 'Cho phép in đơn hàng', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xem thùng rác đơn hàng', 'slug' => 'xem-thung-rac-don-hang', 'description' => 'Cho phép xem thùng rác đơn hàng', 'group_permissions' => 'Đơn hàng'],

            // Quản lý khuyến mãi
            ['name' => 'Xem danh sách khuyến mãi', 'slug' => 'xem-danh-sach-khuyen-mai', 'description' => 'Cho phép xem danh sách khuyến mãi', 'group_permissions' => 'Khuyến mãi'],
            ['name' => 'Thêm khuyến mãi', 'slug' => 'them-khuyen-mai', 'description' => 'Cho phép thêm khuyến mãi mới', 'group_permissions' => 'Khuyến mãi'],
            ['name' => 'Sửa khuyến mãi', 'slug' => 'sua-khuyen-mai', 'description' => 'Cho phép chỉnh sửa khuyến mãi', 'group_permissions' => 'Khuyến mãi'],
            ['name' => 'Xóa khuyến mãi', 'slug' => 'xoa-khuyen-mai', 'description' => 'Cho phép xóa khuyến mãi', 'group_permissions' => 'Khuyến mãi'],
            ['name' => 'Xóa nhiều khuyến mãi', 'slug' => 'xoa-nhieu-khuyen-mai', 'description' => 'Cho phép xóa nhiều khuyến mãi cùng lúc', 'group_permissions' => 'Khuyến mãi'],
            ['name' => 'Khôi phục khuyến mãi', 'slug' => 'khoi-phuc-khuyen-mai', 'description' => 'Cho phép khôi phục khuyến mãi đã xóa', 'group_permissions' => 'Khuyến mãi'],
            ['name' => 'Xóa vĩnh viễn khuyến mãi', 'slug' => 'xoa-vinh-vien-khuyen-mai', 'description' => 'Cho phép xóa vĩnh viễn khuyến mãi', 'group_permissions' => 'Khuyến mãi'],
            ['name' => 'Xem thùng rác khuyến mãi', 'slug' => 'xem-thung-rac-khuyen-mai', 'description' => 'Cho phép xem thùng rác khuyến mãi', 'group_permissions' => 'Khuyến mãi'],

            // Quản lý mã giảm giá
            ['name' => 'Xem danh sách mã giảm giá', 'slug' => 'xem-danh-sach-ma-giam-gia', 'description' => 'Cho phép xem danh sách mã giảm giá', 'group_permissions' => 'Mã giảm giá'],
            ['name' => 'Thêm mã giảm giá', 'slug' => 'them-ma-giam-gia', 'description' => 'Cho phép thêm mã giảm giá mới', 'group_permissions' => 'Mã giảm giá'],
            ['name' => 'Sửa mã giảm giá', 'slug' => 'sua-ma-giam-gia', 'description' => 'Cho phép chỉnh sửa mã giảm giá', 'group_permissions' => 'Mã giảm giá'],
            ['name' => 'Xóa mã giảm giá', 'slug' => 'xoa-ma-giam-gia', 'description' => 'Cho phép xóa mã giảm giá', 'group_permissions' => 'Mã giảm giá'],
            ['name' => 'Khôi phục mã giảm giá', 'slug' => 'khoi-phuc-ma-giam-gia', 'description' => 'Cho phép khôi phục mã giảm giá đã xóa', 'group_permissions' => 'Mã giảm giá'],
            ['name' => 'Xóa vĩnh viễn mã giảm giá', 'slug' => 'xoa-vinh-vien-ma-giam-gia', 'description' => 'Cho phép xóa vĩnh viễn mã giảm giá', 'group_permissions' => 'Mã giảm giá'],
            ['name' => 'Xem thùng rác mã giảm giá', 'slug' => 'xem-thung-rac-ma-giam-gia', 'description' => 'Cho phép xem thùng rác mã giảm giá', 'group_permissions' => 'Mã giảm giá'],

            // Quản lý báo cáo
            ['name' => 'Xem báo cáo doanh thu', 'slug' => 'xem-bao-cao-doanh-thu', 'description' => 'Cho phép xem báo cáo doanh thu', 'group_permissions' => 'Báo cáo'],
            ['name' => 'Xem báo cáo sản phẩm', 'slug' => 'xem-bao-cao-san-pham', 'description' => 'Cho phép xem báo cáo sản phẩm', 'group_permissions' => 'Báo cáo'],
            ['name' => 'Xem báo cáo đơn hàng', 'slug' => 'xem-bao-cao-don-hang', 'description' => 'Cho phép xem báo cáo đơn hàng', 'group_permissions' => 'Báo cáo'],
            ['name' => 'Xuất báo cáo', 'slug' => 'xuat-bao-cao', 'description' => 'Cho phép xuất báo cáo', 'group_permissions' => 'Báo cáo'],
            ['name' => 'Xem báo cáo tồn kho', 'slug' => 'xem-bao-cao-ton-kho', 'description' => 'Cho phép xem báo cáo tồn kho', 'group_permissions' => 'Báo cáo'],
            ['name' => 'Xem báo cáo khách hàng', 'slug' => 'xem-bao-cao-khach-hang', 'description' => 'Cho phép xem báo cáo khách hàng', 'group_permissions' => 'Báo cáo'],

            // Quản lý cài đặt
            ['name' => 'Xem cài đặt', 'slug' => 'xem-cai-dat', 'description' => 'Cho phép xem cài đặt hệ thống', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Cập nhật cài đặt', 'slug' => 'cap-nhat-cai-dat', 'description' => 'Cho phép cập nhật cài đặt hệ thống', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý menu', 'slug' => 'quan-ly-menu', 'description' => 'Cho phép quản lý menu hệ thống', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý banner', 'slug' => 'quan-ly-banner', 'description' => 'Cho phép quản lý banner', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý trang tĩnh', 'slug' => 'quan-ly-trang-tinh', 'description' => 'Cho phép quản lý các trang tĩnh', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý liên hệ', 'slug' => 'quan-ly-lien-he', 'description' => 'Cho phép quản lý thông tin liên hệ', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý SEO', 'slug' => 'quan-ly-seo', 'description' => 'Cho phép quản lý thông tin SEO', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý backup', 'slug' => 'quan-ly-backup', 'description' => 'Cho phép quản lý sao lưu dữ liệu', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý log', 'slug' => 'quan-ly-log', 'description' => 'Cho phép xem và quản lý log hệ thống', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý email', 'slug' => 'quan-ly-email', 'description' => 'Cho phép quản lý cấu hình email', 'group_permissions' => 'Cài đặt'],
            ['name' => 'Quản lý thanh toán', 'slug' => 'quan-ly-thanh-toan', 'description' => 'Cho phép quản lý cấu hình thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Quản lý vận chuyển', 'slug' => 'quan-ly-van-chuyen', 'description' => 'Cho phép quản lý cấu hình vận chuyển', 'group_permissions' => 'Vận chuyển'],

            // Quản lý vận chuyển
            ['name' => 'Xem đơn vị vận chuyển', 'slug' => 'xem-don-vi-van-chuyen', 'description' => 'Cho phép xem danh sách đơn vị vận chuyển', 'group_permissions' => 'Vận chuyển'],
            ['name' => 'Thêm đơn vị vận chuyển', 'slug' => 'them-don-vi-van-chuyen', 'description' => 'Cho phép thêm đơn vị vận chuyển mới', 'group_permissions' => 'Vận chuyển'],
            ['name' => 'Sửa đơn vị vận chuyển', 'slug' => 'sua-don-vi-van-chuyen', 'description' => 'Cho phép chỉnh sửa đơn vị vận chuyển', 'group_permissions' => 'Vận chuyển'],
            ['name' => 'Xóa đơn vị vận chuyển', 'slug' => 'xoa-don-vi-van-chuyen', 'description' => 'Cho phép xóa đơn vị vận chuyển', 'group_permissions' => 'Vận chuyển'],
            ['name' => 'Khôi phục đơn vị vận chuyển', 'slug' => 'khoi-phuc-don-vi-van-chuyen', 'description' => 'Cho phép khôi phục đơn vị vận chuyển đã xóa', 'group_permissions' => 'Vận chuyển'],
            ['name' => 'Xóa vĩnh viễn đơn vị vận chuyển', 'slug' => 'xoa-vinh-vien-don-vi-van-chuyen', 'description' => 'Cho phép xóa vĩnh viễn đơn vị vận chuyển', 'group_permissions' => 'Vận chuyển'],
            ['name' => 'Xem thùng rác đơn vị vận chuyển', 'slug' => 'xem-thung-rac-don-vi-van-chuyen', 'description' => 'Cho phép xem thùng rác đơn vị vận chuyển', 'group_permissions' => 'Vận chuyển'],

            // Quản lý thương hiệu
            ['name' => 'Xem danh sách thương hiệu', 'slug' => 'xem-danh-sach-thuong-hieu', 'description' => 'Cho phép xem danh sách thương hiệu', 'group_permissions' => 'Thương hiệu'],
            ['name' => 'Thêm thương hiệu', 'slug' => 'them-thuong-hieu', 'description' => 'Cho phép thêm thương hiệu mới', 'group_permissions' => 'Thương hiệu'],
            ['name' => 'Sửa thương hiệu', 'slug' => 'sua-thuong-hieu', 'description' => 'Cho phép chỉnh sửa thương hiệu', 'group_permissions' => 'Thương hiệu'],
            ['name' => 'Xóa thương hiệu', 'slug' => 'xoa-thuong-hieu', 'description' => 'Cho phép xóa thương hiệu', 'group_permissions' => 'Thương hiệu'],
            ['name' => 'Xóa nhiều thương hiệu', 'slug' => 'xoa-nhieu-thuong-hieu', 'description' => 'Cho phép xóa nhiều thương hiệu cùng lúc', 'group_permissions' => 'Thương hiệu'],
            ['name' => 'Khôi phục thương hiệu', 'slug' => 'khoi-phuc-thuong-hieu', 'description' => 'Cho phép khôi phục thương hiệu đã xóa', 'group_permissions' => 'Thương hiệu'],
            ['name' => 'Xóa vĩnh viễn thương hiệu', 'slug' => 'xoa-vinh-vien-thuong-hieu', 'description' => 'Cho phép xóa vĩnh viễn thương hiệu', 'group_permissions' => 'Thương hiệu'],
            ['name' => 'Xem thùng rác thương hiệu', 'slug' => 'xem-thung-rac-thuong-hieu', 'description' => 'Cho phép xem thùng rác thương hiệu', 'group_permissions' => 'Thương hiệu'],

            // Quản lý biến thể sản phẩm
            ['name' => 'Xem biến thể sản phẩm', 'slug' => 'xem-bien-the-san-pham', 'description' => 'Cho phép xem biến thể sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Thêm biến thể sản phẩm', 'slug' => 'them-bien-the-san-pham', 'description' => 'Cho phép thêm biến thể sản phẩm mới', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Sửa biến thể sản phẩm', 'slug' => 'sua-bien-the-san-pham', 'description' => 'Cho phép chỉnh sửa biến thể sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa biến thể sản phẩm', 'slug' => 'xoa-bien-the-san-pham', 'description' => 'Cho phép xóa biến thể sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Khôi phục biến thể sản phẩm', 'slug' => 'khoi-phuc-bien-the-san-pham', 'description' => 'Cho phép khôi phục biến thể sản phẩm đã xóa', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa vĩnh viễn biến thể sản phẩm', 'slug' => 'xoa-vinh-vien-bien-the-san-pham', 'description' => 'Cho phép xóa vĩnh viễn biến thể sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xem thùng rác biến thể sản phẩm', 'slug' => 'xem-thung-rac-bien-the-san-pham', 'description' => 'Cho phép xem thùng rác biến thể sản phẩm', 'group_permissions' => 'Sản phẩm'],

            // Quản lý ảnh sản phẩm
            ['name' => 'Xem ảnh sản phẩm', 'slug' => 'xem-anh-san-pham', 'description' => 'Cho phép xem ảnh sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Thêm ảnh sản phẩm', 'slug' => 'them-anh-san-pham', 'description' => 'Cho phép thêm ảnh sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Sửa ảnh sản phẩm', 'slug' => 'sua-anh-san-pham', 'description' => 'Cho phép sửa ảnh sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa ảnh sản phẩm', 'slug' => 'xoa-anh-san-pham', 'description' => 'Cho phép xóa ảnh sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Đặt ảnh đại diện', 'slug' => 'dat-anh-dai-dien', 'description' => 'Cho phép đặt ảnh đại diện sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Khôi phục ảnh sản phẩm', 'slug' => 'khoi-phuc-anh-san-pham', 'description' => 'Cho phép khôi phục ảnh sản phẩm đã xóa', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa vĩnh viễn ảnh sản phẩm', 'slug' => 'xoa-vinh-vien-anh-san-pham', 'description' => 'Cho phép xóa vĩnh viễn ảnh sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xem thùng rác ảnh sản phẩm', 'slug' => 'xem-thung-rac-anh-san-pham', 'description' => 'Cho phép xem thùng rác ảnh sản phẩm', 'group_permissions' => 'Sản phẩm'],

            // Quản lý biến thể
            ['name' => 'Xem biến thể', 'slug' => 'xem-bien-the', 'description' => 'Cho phép xem biến thể sản phẩm', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Thêm biến thể', 'slug' => 'them-bien-the', 'description' => 'Cho phép thêm biến thể mới', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Sửa biến thể', 'slug' => 'sua-bien-the', 'description' => 'Cho phép sửa biến thể', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa biến thể', 'slug' => 'xoa-bien-the', 'description' => 'Cho phép xóa biến thể', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Khôi phục biến thể', 'slug' => 'khoi-phuc-bien-the', 'description' => 'Cho phép khôi phục biến thể đã xóa', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa vĩnh viễn biến thể', 'slug' => 'xoa-vinh-vien-bien-the', 'description' => 'Cho phép xóa vĩnh viễn biến thể', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xem thùng rác biến thể', 'slug' => 'xem-thung-rac-bien-the', 'description' => 'Cho phép xem thùng rác biến thể', 'group_permissions' => 'Sản phẩm'],

            // Quản lý ảnh biến thể
            ['name' => 'Xem ảnh biến thể', 'slug' => 'xem-anh-bien-the', 'description' => 'Cho phép xem ảnh biến thể', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Thêm ảnh biến thể', 'slug' => 'them-anh-bien-the', 'description' => 'Cho phép thêm ảnh biến thể', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa ảnh biến thể', 'slug' => 'xoa-anh-bien-the', 'description' => 'Cho phép xóa ảnh biến thể', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Đặt ảnh đại diện biến thể', 'slug' => 'dat-anh-dai-dien-bien-the', 'description' => 'Cho phép đặt ảnh đại diện biến thể', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Khôi phục ảnh biến thể', 'slug' => 'khoi-phuc-anh-bien-the', 'description' => 'Cho phép khôi phục ảnh biến thể đã xóa', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa vĩnh viễn ảnh biến thể', 'slug' => 'xoa-vinh-vien-anh-bien-the', 'description' => 'Cho phép xóa vĩnh viễn ảnh biến thể', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xem thùng rác ảnh biến thể', 'slug' => 'xem-thung-rac-anh-bien-the', 'description' => 'Cho phép xem thùng rác ảnh biến thể', 'group_permissions' => 'Sản phẩm'],

            // Quản lý màu sắc
            ['name' => 'Xem màu sắc', 'slug' => 'xem-mau-sac', 'description' => 'Cho phép xem danh sách màu sắc', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Thêm màu sắc', 'slug' => 'them-mau-sac', 'description' => 'Cho phép thêm màu sắc mới', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Sửa màu sắc', 'slug' => 'sua-mau-sac', 'description' => 'Cho phép chỉnh sửa màu sắc', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa màu sắc', 'slug' => 'xoa-mau-sac', 'description' => 'Cho phép xóa màu sắc', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Khôi phục màu sắc', 'slug' => 'khoi-phuc-mau-sac', 'description' => 'Cho phép khôi phục màu sắc đã xóa', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa vĩnh viễn màu sắc', 'slug' => 'xoa-vinh-vien-mau-sac', 'description' => 'Cho phép xóa vĩnh viễn màu sắc', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xem thùng rác màu sắc', 'slug' => 'xem-thung-rac-mau-sac', 'description' => 'Cho phép xem thùng rác màu sắc', 'group_permissions' => 'Sản phẩm'],

            // Quản lý kích thước
            ['name' => 'Xem kích thước', 'slug' => 'xem-kich-thuoc', 'description' => 'Cho phép xem danh sách kích thước', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Thêm kích thước', 'slug' => 'them-kich-thuoc', 'description' => 'Cho phép thêm kích thước mới', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Sửa kích thước', 'slug' => 'sua-kich-thuoc', 'description' => 'Cho phép chỉnh sửa kích thước', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa kích thước', 'slug' => 'xoa-kich-thuoc', 'description' => 'Cho phép xóa kích thước', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Khôi phục kích thước', 'slug' => 'khoi-phuc-kich-thuoc', 'description' => 'Cho phép khôi phục kích thước đã xóa', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xóa vĩnh viễn kích thước', 'slug' => 'xoa-vinh-vien-kich-thuoc', 'description' => 'Cho phép xóa vĩnh viễn kích thước', 'group_permissions' => 'Sản phẩm'],
            ['name' => 'Xem thùng rác kích thước', 'slug' => 'xem-thung-rac-kich-thuoc', 'description' => 'Cho phép xem thùng rác kích thước', 'group_permissions' => 'Sản phẩm'],

            // Quản lý thanh toán
            ['name' => 'Xem thanh toán', 'slug' => 'xem-thanh-toan', 'description' => 'Cho phép xem thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Cập nhật trạng thái thanh toán', 'slug' => 'cap-nhat-trang-thai-thanh-toan', 'description' => 'Cho phép cập nhật trạng thái thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'In hóa đơn', 'slug' => 'in-hoa-don', 'description' => 'Cho phép in hóa đơn', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Xóa thanh toán', 'slug' => 'xoa-thanh-toan', 'description' => 'Cho phép xóa thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Khôi phục thanh toán', 'slug' => 'khoi-phuc-thanh-toan', 'description' => 'Cho phép khôi phục thanh toán đã xóa', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Xóa vĩnh viễn thanh toán', 'slug' => 'xoa-vinh-vien-thanh-toan', 'description' => 'Cho phép xóa vĩnh viễn thanh toán', 'group_permissions' => 'Thanh toán'],
            ['name' => 'Xem thùng rác thanh toán', 'slug' => 'xem-thung-rac-thanh-toan', 'description' => 'Cho phép xem thùng rác thanh toán', 'group_permissions' => 'Thanh toán'],

            // Quản lý bình luận
            ['name' => 'Xem bình luận', 'slug' => 'xem-binh-luan', 'description' => 'Cho phép xem bình luận', 'group_permissions' => 'Bình luận'],
            ['name' => 'Thêm bình luận', 'slug' => 'them-binh-luan', 'description' => 'Cho phép thêm bình luận', 'group_permissions' => 'Bình luận'],
            ['name' => 'Sửa bình luận', 'slug' => 'sua-binh-luan', 'description' => 'Cho phép sửa bình luận', 'group_permissions' => 'Bình luận'],
            ['name' => 'Xóa bình luận', 'slug' => 'xoa-binh-luan', 'description' => 'Cho phép xóa bình luận', 'group_permissions' => 'Bình luận'],
            ['name' => 'Khôi phục bình luận', 'slug' => 'khoi-phuc-binh-luan', 'description' => 'Cho phép khôi phục bình luận', 'group_permissions' => 'Bình luận'],
            ['name' => 'Xóa vĩnh viễn bình luận', 'slug' => 'xoa-vinh-vien-binh-luan', 'description' => 'Cho phép xóa vĩnh viễn bình luận', 'group_permissions' => 'Bình luận'],
            ['name' => 'Ẩn hiện bình luận', 'slug' => 'an-hien-binh-luan', 'description' => 'Cho phép ẩn hiện bình luận', 'group_permissions' => 'Bình luận'],
            ['name' => 'Xem thùng rác bình luận', 'slug' => 'xem-thung-rac-binh-luan', 'description' => 'Cho phép xem thùng rác bình luận', 'group_permissions' => 'Bình luận'],

            // Quản lý tin tức
            ['name' => 'Xem tin tức', 'slug' => 'xem-news', 'description' => 'Cho phép xem tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Thêm tin tức', 'slug' => 'them-news', 'description' => 'Cho phép thêm tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Sửa tin tức', 'slug' => 'sua-news', 'description' => 'Cho phép chỉnh sửa tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Xóa tin tức', 'slug' => 'xoa-news', 'description' => 'Cho phép xóa tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Xóa nhiều tin tức', 'slug' => 'xoa-nhieu-news', 'description' => 'Cho phép xóa nhiều tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Khôi phục tin tức', 'slug' => 'khoi-phuc-news', 'description' => 'Cho phép khôi phục tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Xóa vĩnh viễn tin tức', 'slug' => 'xoa-vinh-vien-news', 'description' => 'Cho phép xóa vĩnh viễn tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Xem thùng rác tin tức', 'slug' => 'xem-thung-rac-news', 'description' => 'Cho phép xem thùng rác tin tức', 'group_permissions' => 'Tin tức'],

            //Quản lý danh mục tin tức
            ['name' => 'Xem danh mục tin tức', 'slug' => 'xem-danh-muc-tin-tuc', 'description' => 'Cho phép xem danh mục tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Thêm danh mục tin tức', 'slug' => 'them-danh-muc-tin-tuc', 'description' => 'Cho phép thêm danh mục tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Sửa danh mục tin tức', 'slug' => 'sua-danh-muc-tin-tuc', 'description' => 'Cho phép chỉnh sửa danh mục tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Xóa danh mục tin tức', 'slug' => 'xoa-danh-muc-tin-tuc', 'description' => 'Cho phép xóa danh mục tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Xóa nhiều danh mục tin tức', 'slug' => 'xoa-nhieu-danh-muc-tin-tuc', 'description' => 'Cho phép xóa nhiều danh mục tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Khôi phục danh mục tin tức', 'slug' => 'khoi-phuc-danh-muc-tin-tuc', 'description' => 'Cho phép khôi phục danh mục tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Xóa vĩnh viễn danh mục tin tức', 'slug' => 'xoa-vinh-vien-danh-muc-tin-tuc', 'description' => 'Cho phép xóa vĩnh viễn danh mục tin tức', 'group_permissions' => 'Tin tức'],
            ['name' => 'Xem thùng rác danh mục tin tức', 'slug' => 'xem-thung-rac-danh-muc-tin-tuc', 'description' => 'Cho phép xem thùng rác danh mục tin tức', 'group_permissions' => 'Tin tức'],

            //Quản lý lý do huỷ đơn
            ['name' => 'Xem lý do huỷ đơn', 'slug' => 'xem-ly-do-huy-don', 'description' => 'Cho phép xem danh sách lý do huỷ đơn', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Thêm lý do huỷ đơn', 'slug' => 'them-ly-do-huy-don', 'description' => 'Cho phép thêm lý do huỷ đơn', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Sửa lý do huỷ đơn', 'slug' => 'sua-ly-do-huy-don', 'description' => 'Cho phép chỉnh sửa lý do huỷ đơn', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xóa lý do huỷ đơn', 'slug' => 'xoa-ly-do-huy-don', 'description' => 'Cho phép xóa lý do huỷ đơn', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xóa nhiều lý do huỷ đơn', 'slug' => 'xoa-nhieu-ly-do-huy-don', 'description' => 'Cho phép xóa nhiều lý do huỷ đơn', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Khôi phục lý do huỷ đơn', 'slug' => 'khoi-phuc-ly-do-huy-don', 'description' => 'Cho phép khôi phục lý do huỷ đơn', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xóa vĩnh viễn lý do huỷ đơn', 'slug' => 'xoa-vinh-vien-ly-do-huy-don', 'description' => 'Cho phép xóa vĩnh viễn lý do huỷ đơn', 'group_permissions' => 'Đơn hàng'],
            ['name' => 'Xem thùng rác lý do huỷ đơn', 'slug' => 'xem-thung-rac-ly-do-huy-don', 'description' => 'Cho phép xem thùng rác lý do huỷ đơn', 'group_permissions' => 'Đơn hàng'],

            //Quản lý đánh giá
            ['name' => 'Xem danh sách đánh giá', 'slug' => 'xem-danh-sach-danh-gia', 'description' => 'Cho phép xem danh sách đánh giá', 'group_permissions' => 'Đánh giá'],
            ['name' => 'Xóa đánh giá', 'slug' => 'xoa-danh-gia', 'description' => 'Cho phép xóa đánh giá', 'group_permissions' => 'Đánh giá'],
            ['name' => 'Xóa nhiều đánh giá', 'slug' => 'xoa-nhieu-danh-gia', 'description' => 'Cho phép xóa nhiều đánh giá', 'group_permissions' => 'Đánh giá'],

            // Quản lý dashboard
            ['name' => 'Xem dashboard', 'slug' => 'xem-dashboard', 'description' => 'Cho phép xem trang dashboard', 'group_permissions' => 'Dashboard'],
            ['name' => 'Xem thống kê', 'slug' => 'xem-thong-ke', 'description' => 'Cho phép xem thống kê hệ thống', 'group_permissions' => 'Dashboard'],
            ['name' => 'Xem biểu đồ', 'slug' => 'xem-bieu-do', 'description' => 'Cho phép xem biểu đồ thống kê', 'group_permissions' => 'Dashboard'],
            ['name' => 'Xuất báo cáo dashboard', 'slug' => 'xuat-bao-cao-dashboard', 'description' => 'Cho phép xuất báo cáo từ dashboard', 'group_permissions' => 'Dashboard'],

            // Quản lý hỗ trợ khách hàng
            ['name' => 'Xem danh sách hỗ trợ khách hàng', 'slug' => 'xem-danh-sach-ho-tro-khach-hang', 'description' => 'Cho phép xem danh sách hỗ trợ khách hàng', 'group_permissions' => 'Khách hàng'],
            ['name' => 'Thêm hỗ trợ khách hàng', 'slug' => 'them-ho-tro-khach-hang', 'description' => 'Cho phép thêm hỗ trợ khách hàng', 'group_permissions' => 'Khách hàng'],
            ['name' => 'Sửa hỗ trợ khách hàng', 'slug' => 'sua-ho-tro-khach-hang', 'description' => 'Cho phép sửa hỗ trợ khách hàng', 'group_permissions' => 'Khách hàng'],
            ['name' => 'Xóa hỗ trợ khách hàng', 'slug' => 'xoa-ho-tro-khach-hang', 'description' => 'Cho phép xóa hỗ trợ khách hàng', 'group_permissions' => 'Khách hàng'],
            ['name' => 'Cập nhật trạng thái hỗ trợ khách hàng', 'slug' => 'cap-nhat-trang-thai-ho-tro-khach-hang', 'description' => 'Cho phép cập nhật trạng thái hỗ trợ khách hàng', 'group_permissions' => 'Khách hàng'],

            // Quản lý thông báo
            ['name' => 'Xem danh sách thông báo', 'slug' => 'xem-danh-sach-thong-bao', 'description' => 'Cho phép xem danh sách thông báo', 'group_permissions' => 'Thông báo'],
            ['name' => 'Thêm thông báo', 'slug' => 'them-thong-bao', 'description' => 'Cho phép thêm thông báo', 'group_permissions' => 'Thông báo'],

            // Quản lý liên hệ
            ['name' => 'Xem danh sách liên hệ', 'slug' => 'xem-danh-sach-lien-he', 'description' => 'Cho phép xem danh sách liên hệ', 'group_permissions' => 'Liên hệ'],
            ['name' => 'Xem chi tiết liên hệ', 'slug' => 'xem-chi-tiet-lien-he', 'description' => 'Cho phép xem chi tiết liên hệ', 'group_permissions' => 'Liên hệ'],
            ['name' => 'Xem thùng rác liên hệ', 'slug' => 'xem-thung-rac-lien-he', 'description' => 'Cho phép xem thùng rác liên hệ', 'group_permissions' => 'Liên hệ'],
            ['name' => 'Sửa liên hệ', 'slug' => 'sua-lien-he', 'description' => 'Cho phép sửa liên hệ', 'group_permissions' => 'Liên hệ'],
            ['name' => 'Xóa liên hệ', 'slug' => 'xoa-lien-he', 'description' => 'Cho phép xóa liên hệ', 'group_permissions' => 'Liên hệ'],
            ['name' => 'Xóa nhiều liên hệ', 'slug' => 'xoa-nhieu-lien-he', 'description' => 'Cho phép xóa nhiều liên hệ', 'group_permissions' => 'Liên hệ'],
            ['name' => 'Khôi phục liên hệ', 'slug' => 'khoi-phuc-lien-he', 'description' => 'Cho phép khôi phục liên hệ', 'group_permissions' => 'Liên hệ'],
            ['name' => 'Xóa vĩnh viễn liên hệ', 'slug' => 'xoa-vinh-vien-lien-he', 'description' => 'Cho phép xóa vĩnh viễn liên hệ', 'group_permissions' => 'Liên hệ'],
            ['name' => 'Gửi email liên hệ', 'slug' => 'gui-email-lien-he', 'description' => 'Cho phép gửi email liên hệ', 'group_permissions' => 'Liên hệ'],

            // Quản lý độ cận
            ['name' => 'Xem độ cận', 'slug' => 'xem-do-can', 'description' => 'Cho phép xem danh sách độ cận', 'group_permissions' => 'Độ cận'],
            ['name' => 'Thêm độ cận', 'slug' => 'them-do-can', 'description' => 'Cho phép thêm độ cận mới', 'group_permissions' => 'Độ cận'],
            ['name' => 'Sửa độ cận', 'slug' => 'sua-do-can', 'description' => 'Cho phép chỉnh sửa độ cận', 'group_permissions' => 'Độ cận'],
            ['name' => 'Xóa độ cận', 'slug' => 'xoa-do-can', 'description' => 'Cho phép xóa độ cận', 'group_permissions' => 'Độ cận'],

            // Quản lý độ loạn
            ['name' => 'Xem độ loạn', 'slug' => 'xem-do-loan', 'description' => 'Cho phép xem danh sách độ loạn', 'group_permissions' => 'Độ loạn'],
            ['name' => 'Thêm độ loạn', 'slug' => 'them-do-loan', 'description' => 'Cho phép thêm độ loạn mới', 'group_permissions' => 'Độ loạn'],
            ['name' => 'Sửa độ loạn', 'slug' => 'sua-do-loan', 'description' => 'Cho phép chỉnh sửa độ loạn', 'group_permissions' => 'Độ loạn'],
            ['name' => 'Xóa độ loạn', 'slug' => 'xoa-do-loan', 'description' => 'Cho phép xóa độ loạn', 'group_permissions' => 'Độ loạn'],

            // Quản lý kho
            ['name' => 'Xem giao dịch kho', 'slug' => 'xem-giao-dich-kho', 'description' => 'Cho phép xem lịch sử giao dịch kho', 'group_permissions' => 'Kho'],
            ['name' => 'Thêm giao dịch kho', 'slug' => 'them-giao-dich-kho', 'description' => 'Cho phép thực hiện nhập/xuất kho', 'group_permissions' => 'Kho'],
            ['name' => 'In phiếu kho', 'slug' => 'in-phieu-kho', 'description' => 'Cho phép in phiếu kho', 'group_permissions' => 'Kho'],
        ];

        // Thêm timestamps cho mỗi permission
        foreach ($permissions as &$permission) {
            $permission['created_at'] = now();
            $permission['updated_at'] = now();
            if (!isset($permission['group_permissions'])) {
                $permission['group_permissions'] = null;
            }
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
            'xem-anh-bien-the',
            'quan-ly-ton-kho',
            'xem-giao-dich-kho',
            'them-giao-dich-kho',
            'in-phieu-kho',
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
