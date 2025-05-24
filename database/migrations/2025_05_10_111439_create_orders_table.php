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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->comment('Mã đơn hàng');
            // Thông tin liên kết
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->nullOnDelete();

            // Thông tin người đặt hàng
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('customer_address');

            // Thông tin người nhận
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_email')->nullable();
            $table->text('shipping_address');

            // Thông tin thanh toán
            $table->decimal('total_amount', 10, 2);
            $table->decimal('subtotal', 10, 2)->comment('Tổng tiền hàng trước khi áp dụng giảm giá');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('Số tiền được giảm giá');
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->json('payment_details')->nullable();
            $table->enum('payment_status', [
                'pending',      // Chờ thanh toán
                'paid',        // Đã thanh toán
                'failed',      // Thanh toán thất bại
                'refunded',    // Đã hoàn tiền
                'cancelled',   // Đã huỷ
                'partially_paid', // Thanh toán một phần
                'disputed'     // Đang tranh chấp
            ])->default('pending');

            // Trạng thái đơn hàng
            $table->enum('status', [
                'pending',           // Đơn hàng vừa được tạo
                'awaiting_payment',  // Chờ thanh toán
                'confirmed',         // Đã xác nhận đơn
                'processing',        // Đang đóng gói/kiểm hàng
                'shipping',          // Đang vận chuyển
                'delivered',         // Đã giao hàng
                'returned',          // Khách trả hàng
                'processing_return', // Đang xử lý trả hàng
                'refunded',          // Đã hoàn tiền
            ])->default('pending');

            // Thông tin bổ sung
            $table->text('note')->nullable()->comment('Ghi chú từ khách hàng');
            $table->text('admin_note')->nullable()->comment('Ghi chú của admin');
            $table->timestamp('confirmed_at')->nullable()->comment('Thời điểm xác nhận đơn hàng');
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};