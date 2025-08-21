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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            // Foreign key to link to the users table
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Foreign key to link to the quizzes table
            $table->foreignId('quiz_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->unsignedTinyInteger('rating'); // Stores a small integer (1-5)
            $table->timestamps(); // created_at and updated_at

            // Prevents a user from rating the same quiz more than once
            $table->unique(['user_id', 'quiz_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
