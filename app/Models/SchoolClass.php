<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    // Duy kiểm tra lại tên bảng trong phpMyAdmin, nếu là 'school_classes' thì sửa lại nhé
    protected $table = 'classes'; 
    
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',       // PHẢI CÓ DÒNG NÀY để lưu tên lớp
        'faculty_id',
    ];

    // Quan hệ nghịch đảo: Một lớp thuộc về một khoa
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }

    // Quan hệ: Một lớp có nhiều sinh viên (Dùng để check Acceptance Criteria 4 khi xóa)
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'class_id', 'id');
    }
}