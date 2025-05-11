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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name', 125);
            $table->unsignedBigInteger('logo_id')->nullable();
            $table->foreign('logo_id')->references('id')->on('upload_files')->onDelete('set null');
            $table->string('contact_email', 125);
            $table->string('hotline', 20);
            $table->text('address');
            $table->string('facebook_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
