<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    public $timestamps = false;
    protected $primaryKey = ['year', 'semester'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'year',
        'semester',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
