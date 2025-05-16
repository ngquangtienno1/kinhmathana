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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name', 125);
            $table->string('logo_url', 255)->nullable();
            $table->string('contact_email', 125);
            $table->string('hotline', 20);
            $table->text('address');
            $table->string('facebook_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();

            // Cấu hình vận chuyển
            $table->decimal('default_shipping_fee', 10, 2)->default(0);
            $table->json('shipping_providers')->nullable(); // Danh sách đơn vị giao hàng
            $table->json('shipping_fee_by_province')->nullable(); // Phí ship theo tỉnh/thành

            // Cấu hình email
            $table->string('smtp_host', 255)->nullable();
            $table->string('smtp_port', 10)->nullable();
            $table->string('smtp_username', 255)->nullable();
            $table->string('smtp_password', 255)->nullable();
            $table->string('smtp_encryption', 10)->nullable();
            $table->string('mail_from_address', 255)->nullable();
            $table->string('mail_from_name', 255)->nullable();

            // Cấu hình AI gợi ý sản phẩm
            $table->boolean('enable_ai_recommendation')->default(false);
            $table->string('ai_api_key', 255)->nullable();
            $table->string('ai_api_endpoint', 255)->nullable();
            $table->json('ai_settings')->nullable(); // Các cài đặt khác cho AI

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};