<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizSchedule extends Model
{
    protected $fillable = [
        'group_id',
        'faculty_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'group_id', 'id');
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }
}
