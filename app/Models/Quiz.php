<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quiz extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'duration_minutes',
        'max_attempts',
        'pass_percent',
        'show_answer',
        'require_camera',
        'shuffle_questions',
        'require_login',
        'is_demo',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'show_answer' => 'boolean',
        'require_camera' => 'boolean',
        'shuffle_questions' => 'boolean',
        'require_login' => 'boolean',
        'is_demo' => 'boolean',
    ];

    public function getStatusBadgeAttribute()
    {
        $now = now();
        if ($this->start_date && $now->lt($this->start_date)) {
            return '<span class="badge bg-secondary">Chưa mở</span>';
        }
        if ($this->end_date && $now->gt($this->end_date)) {
            return '<span class="badge bg-danger">Đã kết thúc</span>';
        }
        return '<span class="badge bg-success">Đang diễn ra</span>';
    }

    public function userGroups(): BelongsToMany
    {
        return $this->belongsToMany(UserGroup::class, 'quiz_groups', 'quiz_id', 'group_id');
    }

    public function quizCategoryLevels(): HasMany
    {
        return $this->hasMany(QuizCategoryLevel::class, 'quiz_id', 'id');
    }

    public function questionCategories(): BelongsToMany
    {
        return $this->belongsToMany(QuestionCategory::class, 'quiz_category_levels', 'quiz_id', 'category_id');
    }

    public function quizResults(): HasMany
    {
        return $this->hasMany(QuizResult::class, 'quiz_id', 'id');
    }
}
