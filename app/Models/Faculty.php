<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'faculty_id', 'id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'faculty_id', 'id');
    }

    public function quizSchedules(): HasMany
    {
        return $this->hasMany(QuizSchedule::class, 'faculty_id', 'id');
    }
}
