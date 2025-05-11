<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upload_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 125);
            $table->string('file_type', 50);
            $table->string('file_path', 255);
            $table->string('object_type', 50);
            $table->unsignedBigInteger('object_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upload_files');
    }
};
