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
        Schema::create('quiz_plays', function (Blueprint $table) {
            $table->id();
            // Foreign key to link to the users table, can be nullable for guest plays
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
            
            // Foreign key to link to the quizzes table
            $table->foreignId('quiz_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->integer('score')->default(0);
            $table->integer('time_taken')->nullable(); // in seconds
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('finished_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_plays');
    }
};
