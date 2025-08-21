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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            // Foreign key to link back to the questions table
            $table->foreignId('question_id')
                  ->constrained()
                  ->onDelete('cascade'); // Delete answers if the parent question is deleted

            $table->text('answer_text');
            $table->boolean('is_correct')->default(false); // For multiple-choice correct answers
            $table->string('regex_pattern')->nullable(); // For text-input validation
            $table->string('group_name')->nullable(); // For grouping related answers
            $table->json('data')->nullable(); // To store extra data
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
