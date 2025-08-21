<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'question_id',
        'answer_text',
        'is_correct',
        'regex_pattern',
        'group_name',
        'data',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'data' => 'array', // This will automatically handle JSON encoding/decoding
    ];

    /**
     * Get the question that the answer belongs to.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
