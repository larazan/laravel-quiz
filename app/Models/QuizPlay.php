<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizPlay extends Model
{
    use HasFactory;

    // Define the mass assignable attributes
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'time_taken',
    ];
}
