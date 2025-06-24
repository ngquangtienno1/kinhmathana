<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('import_documents', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã phiếu nhập
            $table->decimal('total_amount', 10, 2)->default(0); // Tổng tiền
            $table->date('import_date'); // Ngày nhập
            $table->string('note')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_documents');
    }
};
