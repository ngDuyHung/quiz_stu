<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'type',
        'content',
        'description',
        'category_id',
        'level_id',
        'times_served',
        'times_correct',
        'times_incorrect',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(QuestionCategory::class, 'category_id', 'id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(QuestionLevel::class, 'level_id', 'id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class, 'question_id', 'id');
    }

    public function resultAnswers(): HasMany
    {
        return $this->hasMany(ResultAnswer::class, 'question_id', 'id');
    }
}
