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
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()
                ->comment('User who made the change (null if system or customer)');
            $table->string('status_from')->nullable();
            $table->string('status_to');
            $table->string('payment_status_from')->nullable();
            $table->string('payment_status_to')->nullable();
            $table->text('comment')->nullable();
            $table->json('additional_data')->nullable()->comment('Any additional data related to the status change');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_histories');
    }
}; 