<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_play_id',
        'question_id',
        'user_answer',
        'is_correct',
        'time_to_answer',
    ];

    /**
     * Get the quiz play that this result belongs to.
     */
    public function quizPlay()
    {
        return $this->belongsTo(QuizPlay::class);
    }

    /**
     * Get the question associated with this result.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
