<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizFeedback extends Model
{
    // Bảng quiz_feedbacks chỉ có cột created_at, không có updated_at
    const UPDATED_AT = null;

    protected $table = 'quiz_feedbacks';

    protected $fillable = [
        'user_id',
        'result_id',
        'formality_score',
        'time_score',
        'content_score',
        'presenter_score',
        'suggestion',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function quizResult(): BelongsTo
    {
        return $this->belongsTo(QuizResult::class, 'result_id', 'id');
    }
}
