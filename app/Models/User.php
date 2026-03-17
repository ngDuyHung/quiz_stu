<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable 
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_code',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'group_id',
        'role',
        'class_id',
        'faculty_id',
        'birthdate',
        'academic_year',
        'degree_type',
        'photo',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date',
        ];
    }

   
    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'group_id', 'id');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id', 'id');
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }

    public function quizResults(): HasMany
    {
        return $this->hasMany(QuizResult::class, 'user_id', 'id');
    }

    public function resultAnswers(): HasMany
    {
        return $this->hasMany(ResultAnswer::class, 'user_id', 'id');
    }

    public function quizFeedbacks(): HasMany
    {
        return $this->hasMany(QuizFeedback::class, 'user_id', 'id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'created_by', 'id');
    }
}
