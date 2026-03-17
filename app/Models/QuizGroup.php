<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizGroup extends Model
{
    protected $table = 'quiz_groups';
    public $timestamps = false;
    protected $fillable = [
        'quiz_id',
        'group_id',
    ];

    protected $primaryKey = ['quiz_id', 'group_id'];
    public $incrementing = false;

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id', 'id');
    }

    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'group_id', 'id');
    }
}
