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

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    private $successCount = 0;

    public function model(array $row)
    {
        // 1. Tìm Faculty và Class (Phải tìm lại vì model() chạy độc lập với validator)
        $faculty = Faculty::where('name', $row['id_khoa'])->orWhere('id', $row['id_khoa'])->first();
        $class = SchoolClass::where('name', $row['id_lop'])->orWhere('id', $row['id_lop'])->first();

        // Nếu dính lỗi validation (Khoa/Lớp không tồn tại), model() vẫn sẽ chạy, 
        // ta PHẢI return null và KHÔNG tăng successCount.
        if (!$faculty || !$class) {
            return null;
        }

        // 2. Xử lý tên
        $nameParts = explode(' ', trim($row['ho_ten']));
        $lastName = array_pop($nameParts);
        $firstName = implode(' ', $nameParts) ?: 'Sinh viên';

        $group = UserGroup::where('name', 'LIKE', '%Sinh viên%')->first();

        // 3. CHỈ TĂNG KHI CHẮC CHẮN INSERT THÀNH CÔNG
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

    public function getRowCount(): int
    {
        return $this->successCount;
    }

    public function rules(): array
    {
        return [
            'ma_sv'   => 'required|unique:users,student_code',
            'email'   => 'required|email|unique:users,email',
            'ho_ten'  => 'required',
            'id_khoa' => 'required',
            'id_lop'  => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($validator->getData() as $key => $data) {
                // Kiểm tra Khoa
                $facultyExists = Faculty::where('name', $data['id_khoa'])
                                        ->orWhere('id', $data['id_khoa'])
                                        ->exists();
                if (!$facultyExists) {
                    $validator->errors()->add($key . '.id_khoa', "Khoa [{$data['id_khoa']}] không tồn tại.");
                }

                // Kiểm tra Lớp
                $classExists = SchoolClass::where('name', $data['id_lop'])
                                          ->orWhere('id', $data['id_lop'])
                                          ->exists();
                if (!$classExists) {
                    $validator->errors()->add($key . '.id_lop', "Lớp [{$data['id_lop']}] không tồn tại.");
                }
            }
        });
    }

    public function customValidationMessages()
    {
        return [
            'ma_sv.unique' => 'Mã sinh viên :input đã tồn tại.',
            'email.unique' => 'Email :input đã tồn tại.',
        ];
    }
}
