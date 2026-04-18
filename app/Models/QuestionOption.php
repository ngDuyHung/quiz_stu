<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionOption extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'question_id',
        'content',
        'match_text',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function resultAnswers(): HasMany
    {
        return $this->hasMany(ResultAnswer::class, 'selected_option_id', 'id');
    }
}
