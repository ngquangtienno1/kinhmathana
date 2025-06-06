<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sphericals', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 5, 2)->unique(); // Giá trị Độ cận, ví dụ: -0.50
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sphericals');
    }
};
