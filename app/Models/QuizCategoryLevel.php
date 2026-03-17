<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizCategoryLevel extends Model
{
    protected $fillable = [
        'quiz_id',
        'category_id',
        'level_id',
        'question_count',
        'score_correct',
        'score_incorrect',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }

    public function questionCategory(): BelongsTo
    {
        return $this->belongsTo(QuestionCategory::class, 'category_id', 'id');
    }

    public function questionLevel(): BelongsTo
    {
        return $this->belongsTo(QuestionLevel::class, 'level_id', 'id');
    }
}
