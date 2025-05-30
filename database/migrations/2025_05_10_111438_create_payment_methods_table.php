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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125); // Tên phương thức thanh toán
            $table->string('code', 50)->unique(); // Mã phương thức thanh toán (cod, banking, momo, vnpay, etc.)
            $table->text('description')->nullable(); // Mô tả phương thức thanh toán
            $table->string('logo', 255)->nullable(); // URL logo phương thức thanh toán
            $table->string('api_key', 255)->nullable(); // API key nếu có tích hợp
            $table->string('api_secret', 255)->nullable(); // API secret nếu có tích hợp
            $table->string('api_endpoint', 255)->nullable(); // Endpoint API nếu có tích hợp
            $table->json('api_settings')->nullable(); // Các cài đặt API khác
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->integer('sort_order')->default(0); // Thứ tự hiển thị
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
