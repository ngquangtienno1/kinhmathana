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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['mới', 'đang xử lý', 'chờ khách', 'đã đóng'])->default('mới');
            $table->enum('priority', ['thấp', 'trung bình', 'cao'])->default('trung bình');
            $table->foreignId('user_id')->constrained(); // Người gửi
            $table->foreignId('assigned_to')->nullable()->constrained('users'); // Nhân viên xử lý
            $table->boolean('is_visible')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};