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
        Schema::create('user_badges', function (Blueprint $table) {
            // We use bigIncrements for a primary key if needed, or composite key
            // No primary key needed for a simple pivot table

            // Foreign key to the users table, a user can have many badges
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Foreign key to the badges table, a badge can be awarded to many users
            $table->foreignId('badge_id')
                ->constrained()
                ->onDelete('cascade');

            // Timestamp for when the badge was earned
            $table->timestamp('earned_at')->useCurrent();

            // Define a composite primary key to ensure a user can only have a specific badge once
            $table->primary(['user_id', 'badge_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_badges');
    }
};
