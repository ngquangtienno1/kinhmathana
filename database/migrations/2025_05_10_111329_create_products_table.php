<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->text('description_short')->nullable();
            $table->text('description_long')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('import_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->decimal('discount_price', 10, 2);
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->string('status', 50)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes(); // <-- Thêm dòng này để hỗ trợ soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
