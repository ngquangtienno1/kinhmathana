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
        Schema::create('shipping_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125); // Tên đơn vị giao hàng
            $table->string('code', 50)->unique(); // Mã đơn vị giao hàng (ví dụ: GHTK, VNPOST, etc.)
            $table->text('description')->nullable();
            $table->string('logo_url', 255)->nullable();
            $table->string('api_key', 255)->nullable(); // API key nếu có tích hợp
            $table->string('api_secret', 255)->nullable(); // API secret nếu có tích hợp
            $table->string('api_endpoint', 255)->nullable(); // Endpoint API nếu có tích hợp
            $table->json('api_settings')->nullable(); // Các cài đặt API khác
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Bảng lưu phí vận chuyển theo tỉnh/thành và đơn vị giao hàng
        Schema::create('shipping_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_provider_id')->constrained('shipping_providers')->onDelete('cascade');
            $table->string('province_code', 10); // Mã tỉnh/thành
            $table->string('province_name', 125); // Tên tỉnh/thành
            $table->decimal('base_fee', 10, 2); // Phí cơ bản
            $table->decimal('weight_fee', 10, 2)->default(0); // Phí theo cân nặng
            $table->decimal('distance_fee', 10, 2)->default(0); // Phí theo khoảng cách
            $table->json('extra_fees')->nullable(); // Các loại phí phát sinh khác
            $table->text('note')->nullable();
            $table->timestamps();

            // Đảm bảo không có phí trùng lặp cho cùng một tỉnh và đơn vị giao hàng
            $table->unique(['shipping_provider_id', 'province_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_fees');
        Schema::dropIfExists('shipping_providers');
    }
};
