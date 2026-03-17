<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'content',
        'created_by',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
