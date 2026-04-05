<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    // Mặc định Laravel tự hiểu Primary Key là 'id' và tự tăng
    protected $fillable = [
        'year',
        'semester',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}