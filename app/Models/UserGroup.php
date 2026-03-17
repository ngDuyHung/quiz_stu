<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'group_id', 'id');
    }

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'quiz_groups', 'group_id', 'quiz_id');
    }

    public function quizSchedules(): HasMany
    {
        return $this->hasMany(QuizSchedule::class, 'group_id', 'id');
    }
}
