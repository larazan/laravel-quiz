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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            
            // Foreign key for the quiz creator
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('set null'); // Set to null if the user is deleted
            
            // Foreign key to the categories table
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('set null'); // Set to null if the category is deleted
            
            $table->string('quiz_type')->default('text'); // e.g., 'text', 'map_click'
            $table->string('slug')->unique(); // Unique slug for friendly URLs
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedBigInteger('times_played')->default(0); // Counter for times played
            $table->string('difficulty')->default('easy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
