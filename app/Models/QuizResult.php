<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizResult extends Model
{
    // Bảng quiz_results chỉ có cột created_at, không có updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'status',
        'started_at',
        'ended_at',
        'total_seconds',
        'score',
        'percentage',
        'ip_address',
        'photo_proof',
    ];

    protected $casts = [
        'quiz_id'    => 'integer',
        'user_id'    => 'integer',
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
        'created_at' => 'datetime',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function resultAnswers(): HasMany
    {
        return $this->hasMany(ResultAnswer::class, 'result_id', 'id');
    }

    public function quizFeedback(): HasMany
    {
        return $this->hasMany(QuizFeedback::class, 'result_id', 'id');
    }
}
