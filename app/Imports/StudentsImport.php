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
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Validator;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithEvents
{
    use Importable, SkipsFailures;

    private $successCount = 0;

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    /**
     * Kiểm tra Header trước khi xử lý dữ liệu
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $reader = $event->getDelegate();
                $sheet = $reader->getActiveSheet();
                $highestColumn = $sheet->getHighestColumn();
                
                // Lấy hàng đầu tiên (Header)
                $currentRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false)[0];
                $currentRow = array_filter($currentRow); // Loại bỏ các ô trống cuối dòng nếu có

                // Header chuẩn từ templates/sample_students.csv
                $expectedHeader = ['ma_sv', 'ho_ten', 'email', 'id_khoa', 'id_lop'];

                // Kiểm tra số lượng cột và nội dung tiêu đề
                if ($currentRow !== $expectedHeader) {
                    $error = "Tệp tin không đúng định dạng mẫu. ";
                    $error .= "Tiêu đề mong đợi: [" . implode(', ', $expectedHeader) . "]. ";
                    $error .= "Tiêu đề thực tế: [" . implode(', ', $currentRow) . "].";
                    
                    throw new \Exception($error);
                }
            },
        ];
    }

    public function model(array $row)
    {
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
            'password'      => $row['ma_sv'], // Model User đã có hashed cast
            'faculty_id'    => $faculty->id,
            'class_id'      => $class->id,
            'group_id'      => $group ? $group->id : null,
            'role'          => 0, 
            'status'        => 'active', 
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
