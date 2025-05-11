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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->nullOnDelete(); // Có thể không áp mã giảm giá
            $table->string('payment_status', 50);
            $table->string('status', 50);
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->text('note')->nullable();
            $table->text('shipping_address');
            $table->timestamps();
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
