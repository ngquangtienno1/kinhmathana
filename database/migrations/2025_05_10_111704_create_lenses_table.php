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
        Schema::create('lenses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->string('type', 50);
            $table->decimal('index', 3, 2);
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lenses');
    }
};
