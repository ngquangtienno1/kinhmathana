<?php

/**
 * Trait HasDepartmentEmail
 * ------------------------
 * Trait này dùng để hỗ trợ gửi email từ nhiều địa chỉ khác nhau (theo từng phòng ban) trong hệ thống.
 * Ví dụ: gửi email xác nhận đơn hàng từ order@domain.com, gửi email hỗ trợ từ support@domain.com...
 *
 * Cách hoạt động:
 * - Hàm getDepartmentEmail($department): Lấy thông tin email (địa chỉ, tên) của phòng ban từ file config (config/mail.php)
 * - Hàm from($department): Gọi lại hàm from của Mailable, truyền vào địa chỉ và tên phòng ban lấy được từ config
 *
 * Lưu ý:
 * - Trait này chỉ cần thiết nếu bạn muốn gửi mail từ nhiều địa chỉ khác nhau tùy từng trường hợp.
 * - Nếu chỉ dùng 1 địa chỉ gửi mail cho toàn hệ thống, có thể bỏ qua trait này.
 *
 * Ví dụ cấu hình trong config/mail.php:
 *   'department_emails' => [
 *       'order' => ['address' => 'order@domain.com', 'name' => 'Bộ phận Đơn hàng'],
 *       'support' => ['address' => 'support@domain.com', 'name' => 'Bộ phận Hỗ trợ'],
 *   ]
 *
 * Ví dụ sử dụng trong Mailable:
 *   $this->from('order') // sẽ gửi từ order@domain.com
 */

namespace App\Traits;

use Illuminate\Mail\Mailables\Envelope;

trait HasDepartmentEmail
{
    protected function getDepartmentEmail(string $department): array
    {
        return config('mail.department_emails.' . $department);
    }

    public function fromDepartment(string $department): self
    {
        $emailConfig = $this->getDepartmentEmail($department);
        return $this->from($emailConfig['address'], $emailConfig['name']);
    }
} 