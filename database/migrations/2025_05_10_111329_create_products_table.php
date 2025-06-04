<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125)->notNull();
            $table->string('sku', 125)->nullable()->unique();
            $table->text('description_short')->nullable();
            $table->text('description_long')->nullable();
            $table->string('product_type', 20)->notNull()->default('simple');
            $table->integer('stock_quantity')->notNull()->default(0); // Sửa đổi: không cho phép NULL, mặc định là 0
            $table->decimal('price', 10, 2)->nullable(); // Giá gốc cho sản phẩm đơn giản
            $table->decimal('sale_price', 10, 2)->nullable(); // Giá khuyến mãi cho sản phẩm đơn giản
            $table->string('slug', 255)->notNull()->unique();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->string('status', 50)->nullable()->default('Hoạt động');
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->string('video_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
