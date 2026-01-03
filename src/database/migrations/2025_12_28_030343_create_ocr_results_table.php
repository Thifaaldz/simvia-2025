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
        Schema::create('ocr_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->string('extracted_name')->nullable();
            $table->string('extracted_nisn', 10)->nullable();
            $table->string('extracted_school')->nullable();
            $table->string('extracted_year')->nullable();
            $table->longText('raw_text')->nullable();
            $table->integer('confidence_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocr_results');
    }
};
