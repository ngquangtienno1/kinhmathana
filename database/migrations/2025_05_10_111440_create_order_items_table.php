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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->decimal('price', 10, 2)->comment('Giá sản phẩm tại thời điểm mua');
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2)->comment('Tổng tiền = price * quantity');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('Số tiền giảm giá cho item này');
            $table->json('product_options')->nullable()->comment('Các tuỳ chọn của sản phẩm (size, color,...)');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};