<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name', 125);
            $table->string('sku', 100)->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('import_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->integer('stock_alert_threshold')->default(10);
            // $table->string('status')->nullable();
            $table->foreignId('color_id')->nullable()->constrained('colors')->onDelete('set null');
            $table->foreignId('size_id')->nullable()->constrained('sizes')->onDelete('set null');
            $table->foreignId('spherical_id')->nullable()->constrained('sphericals')->onDelete('set null');
            $table->foreignId('cylindrical_id')->nullable()->constrained('cylindricals')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variations');
    }
};