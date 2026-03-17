<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionLevel extends Model
{
    protected $fillable = [
        'name',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'level_id', 'id');
    }

    public function quizCategoryLevels(): HasMany
    {
        return $this->hasMany(QuizCategoryLevel::class, 'level_id', 'id');
    }
}
