<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('variation_images', function (Blueprint $table) {
            // Xoá cột image_id cũ nếu tồn tại
            if (Schema::hasColumn('variation_images', 'image_id')) {
                $table->dropForeign(['image_id']);
                $table->dropColumn('image_id');
            }

            // Thêm cột image_path mới
            $table->string('image_path', 255)->after('variation_id');
            $table->boolean('is_thumbnail')->default(false)->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('variation_images', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'is_thumbnail']);
            $table->unsignedBigInteger('image_id')->nullable();
        });
    }
};