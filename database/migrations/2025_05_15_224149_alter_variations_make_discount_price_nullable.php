<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('variations', function (Blueprint $table) {
            $table->decimal('discount_price', 10, 2)->nullable()->change();
        });
    }

    public function down(): void {
        Schema::table('variations', function (Blueprint $table) {
            $table->decimal('discount_price', 10, 2)->default(0)->change();
        });
    }
};
