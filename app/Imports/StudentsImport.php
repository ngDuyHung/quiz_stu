<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Faculty;
use App\Models\SchoolClass;
use App\Models\UserGroup;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    private $successCount = 0;

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {
        // PHẢI tìm lại để lấy ID, nhưng lúc này Validation đã đảm bảo nó tồn tại
        $faculty = Faculty::where('name', $row['id_khoa'])->orWhere('id', $row['id_khoa'])->first();
        $class = SchoolClass::where('name', $row['id_lop'])->orWhere('id', $row['id_lop'])->first();

        $nameParts = explode(' ', trim($row['ho_ten']));
        $lastName = array_pop($nameParts);
        $firstName = implode(' ', $nameParts) ?: 'Sinh viên';
        $group = UserGroup::where('name', 'LIKE', '%Sinh viên%')->first();

        $this->successCount++;

        return new User([
            'student_code'  => $row['ma_sv'],
            'first_name'    => $firstName,
            'last_name'     => $lastName,
            'email'         => $row['email'],
            'password'      => Hash::make($row['ma_sv']),
            'faculty_id'    => $faculty->id,
            'class_id'      => $class->id,
            'group_id'      => $group ? $group->id : null,
            'role'          => 0, 
            'status'        => 1, 
        ]);
    }

    public function getRowCount(): int { return $this->successCount; }

    public function rules(): array
    {
        return [
            'ma_sv'   => 'required|unique:users,student_code',
            'email'   => 'required|email|unique:users,email',
            'ho_ten'  => 'required',
            'id_khoa' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = Faculty::where('name', $value)->orWhere('id', $value)->exists();
                    if (!$exists) {
                        $fail("Khoa [{$value}] không tồn tại trên hệ thống.");
                    }
                },
            ],
            'id_lop' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = SchoolClass::where('name', $value)->orWhere('id', $value)->exists();
                    if (!$exists) {
                        $fail("Lớp [{$value}] không tồn tại trên hệ thống.");
                    }
                },
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_sv.unique' => 'Mã sinh viên [:input] đã tồn tại.',
            'email.unique' => 'Email [:input] đã tồn tại.',
            'ma_sv.required' => 'Mã sinh viên là bắt buộc.',
            'ho_ten.required' => 'Họ tên là bắt buộc.',
            'id_khoa.required' => 'Khoa là bắt buộc.',
            'id_lop.required' => 'Lớp là bắt buộc.',
        ];
    }
}
