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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('variations')->onDelete('cascade');
            $table->enum('type', ['import', 'export', 'adjust']);
            $table->integer('quantity')->unsigned(); // Số lượng dương, type quyết định tăng/giảm
            $table->string('reference')->nullable(); // Mã phiếu nhập/xuất
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->foreignId('import_document_id')->nullable()->constrained('import_documents')->onDelete('set null');
            $table->string('note')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
