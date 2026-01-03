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
Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nisn', 10);
            $table->string('phone', 20);
            $table->string('file_path');
            $table->enum('status', [
                'uploaded',
                'ocr_processing',
                'review_pending',
                'verified',
                'rejected'
            ])->default('uploaded');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
