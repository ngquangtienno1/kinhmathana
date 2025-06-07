<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete()
                ->comment('User thực hiện thay đổi trạng thái');
            $table->enum('old_status', [
                'pending',              // Chờ xác nhận
                'confirmed',            // Đã xác nhận
                'awaiting_pickup',      // Chờ lấy hàng
                'shipping',             // Đang giao
                'delivered',            // Đã giao hàng
                'completed',            // Đã hoàn thành
                'cancelled_by_customer', // Khách hủy đơn
                'cancelled_by_admin',    // Admin hủy đơn
                'delivery_failed',       // Giao thất bại
                'returned_requested',    // Khách trả hàng
                'processing_return',     // Đang xử lý trả hàng
                'return_rejected',       // Trả hàng bị từ chối
                'refunded'              // Đã hoàn tiền
            ])->comment('Trạng thái cũ');
            $table->enum('new_status', [
                'pending',              // Chờ xác nhận
                'confirmed',            // Đã xác nhận
                'awaiting_pickup',      // Chờ lấy hàng
                'shipping',             // Đang giao
                'delivered',            // Đã giao hàng
                'completed',            // Đã hoàn thành
                'cancelled_by_customer', // Khách hủy đơn
                'cancelled_by_admin',    // Admin hủy đơn
                'delivery_failed',       // Giao thất bại
                'returned_requested',    // Khách trả hàng
                'processing_return',     // Đang xử lý trả hàng
                'return_rejected',       // Trả hàng bị từ chối
                'refunded'              // Đã hoàn tiền
            ])->comment('Trạng thái mới');
            $table->text('note')->nullable()->comment('Ghi chú về việc thay đổi trạng thái');
            $table->json('metadata')->nullable()->comment('Dữ liệu bổ sung (VD: thông tin vận chuyển, lý do huỷ...)');
            $table->timestamp('changed_at')->useCurrent()->comment('Thời điểm thay đổi trạng thái');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_logs');
    }
};
