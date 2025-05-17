<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Đổi kiểu dữ liệu của cột status từ enum sang string tạm thời
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(50)");
        
        // Thêm 'cancelled' vào danh sách enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'awaiting_payment', 'confirmed', 'processing', 'shipping', 'delivered', 'returned', 'processing_return', 'refunded', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Đổi kiểu dữ liệu của cột status từ enum sang string tạm thời
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(50)");
        
        // Khôi phục lại enum không có 'cancelled'
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'awaiting_payment', 'confirmed', 'processing', 'shipping', 'delivered', 'returned', 'processing_return', 'refunded') DEFAULT 'pending'");
    }
}; 