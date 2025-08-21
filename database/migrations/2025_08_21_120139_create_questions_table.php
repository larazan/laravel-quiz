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
            // Foreign key to link to the quizzes table, with cascading deletion
            $table->foreignId('quiz_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->text('question_text');
            $table->string('answer_type')->default('text_input'); // e.g., 'text_input', 'multiple_choice'
            $table->unsignedSmallInteger('order'); // To maintain the quiz order
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
