<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class QuestionCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'category_id', 'id');
    }

    public function quizCategoryLevels(): HasMany
    {
        return $this->hasMany(QuizCategoryLevel::class, 'category_id', 'id');
    }

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'quiz_category_levels', 'category_id', 'quiz_id');
    }
}
