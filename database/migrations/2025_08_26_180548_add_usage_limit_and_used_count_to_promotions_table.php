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
        Schema::table('promotions', function (Blueprint $table) {
            // Thêm cột 'usage_limit' kiểu số nguyên, có thể là null
            $table->unsignedInteger('usage_limit')->nullable()->after('end_date');
            
            // Thêm cột 'used_count' kiểu số nguyên, mặc định là 0
            $table->unsignedInteger('used_count')->default(0)->after('usage_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            // Xóa các cột đã thêm
            $table->dropColumn(['usage_limit', 'used_count']);
        });
    }
};
