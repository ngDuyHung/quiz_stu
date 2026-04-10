<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultAnswer extends Model
{
    // Bảng result_answers không có cột timestamps
    public $timestamps = false;

    protected $fillable = [
        'result_id',
        'question_id',
        'selected_option_id',
        'user_id',
        'score',
        'answered_at',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    public function quizResult(): BelongsTo
    {
        return $this->belongsTo(QuizResult::class, 'result_id', 'id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
