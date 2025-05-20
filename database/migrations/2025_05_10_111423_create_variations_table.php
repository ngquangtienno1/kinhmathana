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
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name', 125);
            $table->string('sku', 50)->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('import_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->decimal('discount_price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->timestamps();
            $table->softDeletes(); // <-- Thêm dòng này để hỗ trợ soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variations');
    }
};