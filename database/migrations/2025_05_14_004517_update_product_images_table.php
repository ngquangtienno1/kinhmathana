<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            // Thêm cột image_path nếu chưa tồn tại
            if (!Schema::hasColumn('product_images', 'image_path')) {
                $table->string('image_path')->after('product_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            // Xóa cột image_path nếu tồn tại
            if (Schema::hasColumn('product_images', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
    }
};