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
        Schema::table('website_settings', function (Blueprint $table) {
            $table->boolean('ai_chat_enabled')->default(false)->after('ai_settings');
            $table->integer('ai_guest_limit')->default(5)->after('ai_chat_enabled');
            $table->integer('ai_user_limit')->default(20)->after('ai_guest_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['ai_chat_enabled', 'ai_guest_limit', 'ai_user_limit']);
        });
    }
};
