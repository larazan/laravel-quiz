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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            // Foreign key to link to the overall quiz play record
            $table->foreignId('quiz_play_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Foreign key to link to the specific question
            $table->foreignId('question_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->text('user_answer'); // The text or ID of the user's answer
            $table->boolean('is_correct');
            $table->integer('time_to_answer'); // Time taken to answer this specific question in seconds
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
