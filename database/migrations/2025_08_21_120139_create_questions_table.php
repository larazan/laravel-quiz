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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('type_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('question_text');
            $table->string('image_path')->nullable();
            $table->enum('difficulty', ['easy','medium','hard'])->default('easy');
            $table->integer('points')->default(1);
            $table->unsignedInteger('time_limit_seconds')->nullable();
            $table->unsignedTinyInteger('order')->default(0);
            $table->boolean('is_private')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('hint')->nullable(); // Optional hint for the question
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
