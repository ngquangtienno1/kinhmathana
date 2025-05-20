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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('entity_type', 50); // Ví dụ: 'news', 'product'
            $table->unsignedBigInteger('entity_id');
            $table->text('content');
            $table->boolean('is_hidden')->default(false);
            $table->enum('status', ['chờ duyệt', 'đã duyệt', 'spam', 'chặn'])->default('chờ duyệt');
            $table->timestamps();
            $table->softDeletes(); // <-- Thêm dòng này để hỗ trợ soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};