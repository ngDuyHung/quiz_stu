<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Faculty;
use App\Models\SchoolClass;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 0)->with('faculty', 'schoolClass', 'userGroup');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('faculty_id')) $query->where('faculty_id', $request->faculty_id);
        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);
        if ($request->filled('group_id')) $query->where('group_id', $request->group_id);
        if ($request->filled('status')) $query->where('status', $request->status);

        return view('admin.students.index', [
            'students' => $query->paginate(15),
            'faculties' => Faculty::orderBy('name')->get(),
            'classes' => SchoolClass::orderBy('name')->get(),
            'userGroups' => UserGroup::orderBy('name')->get(),
            'request' => $request
        ]);
    }

    public function create()
    {
        return view('admin.students.create', [
            'faculties' => Faculty::orderBy('name')->get(),
            'classes' => SchoolClass::orderBy('name')->get(),
            'userGroups' => UserGroup::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_code' => ['required', 'string', 'max:50', Rule::unique('users', 'student_code')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'faculty_id' => 'required|exists:faculties,id',
            'class_id' => 'required|exists:school_classes,id', // Đổi từ classes thành school_classes nếu cần
            'group_id' => 'nullable|exists:user_groups,id',
            'birthdate' => 'nullable|date',
            'academic_year' => 'nullable|string|max:50',
            'degree_type' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048',
            'status' => 'required|in:0,1'
        ]);

        $validated['role'] = 0;
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        // Bỏ Hash::make vì Model User đã có cast 'password' => 'hashed'
        $validated['password'] = $validated['student_code'] ?: '12345678';
        $validated['status'] = 'active';
        User::create($validated);

        return redirect()->route('admin.students.index')->with('success', 'Thêm sinh viên thành công');
    }

    // ... Các hàm show, edit, update, destroy, toggleStatus, resetPassword giữ nguyên như code của bạn ...

    public function downloadTemplate()
    {
        $headers = ['student_code', 'email', 'first_name', 'last_name', 'phone', 'faculty_id', 'class_id', 'group_id', 'birthdate', 'academic_year', 'degree_type', 'status'];
        $sampleData = [['SV001', 'sv001@example.com', 'Nguyễn', 'Văn A', '0123456789', 'CNTT', 'LH01', '1', '2000-01-01', '2022', 'Đại học', '1']];

        return response()->streamDownload(function () use ($headers, $sampleData) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($file, $headers);
            foreach ($sampleData as $row) fputcsv($file, $row);
            fclose($file);
        }, 'students_template.csv');
    }

    public function processImport(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:5120']);

        try {
            $file = $request->file('csv_file');
            $path = $file->store('imports', 'local');
            $fullPath = Storage::disk('local')->path($path);

            $results = ['success' => 0, 'failed' => 0, 'total' => 0, 'errors' => []];

            // 1. Tự động nhận diện dấu phân cách (Comma , hoặc Semicolon ;)
            $firstLine = file_get_contents($fullPath, false, null, 0, 500);
            $separator = (strpos($firstLine, ';') !== false) ? ';' : ',';

            $csvFile = new \SplFileObject($fullPath, 'r');
            $csvFile->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);
            $csvFile->setCsvControl($separator); // Thiết lập dấu phân cách đã nhận diện

            $headerRow = null;
            $rowNumber = 0;

            foreach ($csvFile as $row) {
                $rowNumber++;
                if (empty($row) || !isset($row[0])) continue;

                // 2. Xử lý Header: Dọn dẹp ký tự BOM và khoảng trắng
                if ($headerRow === null) {
                    $headerRow = array_map(function ($item) {
                        $clean = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $item);
                        return trim($clean);
                    }, $row);
                    continue;
                }

                $results['total']++;

                // Kiểm tra số lượng cột
                if (count($headerRow) !== count($row)) {
                    $results['failed']++;
                    $results['errors'][] = ['row' => $rowNumber, 'messages' => ['Số cột không khớp với tiêu đề']];
                    continue;
                }

                $data = array_combine($headerRow, $row);
                $data = array_map('trim', $data);

                // 3. Kiểm tra khóa quan trọng nhất
                if (!isset($data['student_code'])) {
                    throw new \Exception("Không thể tìm thấy cột 'student_code'. Hãy kiểm tra lại tiêu đề file.");
                }

                // Logic lưu Database (Giữ nguyên phần validate và User::create của bạn)
                try {
                    // Kiểm tra trùng lặp nhanh
                    if (\App\Models\User::where('student_code', $data['student_code'])->exists()) {
                        $results['failed']++;
                        $results['errors'][] = ['row' => $rowNumber, 'code' => $data['student_code'], 'messages' => ['Mã sinh viên đã tồn tại']];
                        continue;
                    }

                    \App\Models\User::create([
                        'student_code' => $data['student_code'],
                        'email'        => $data['email'],
                        'password'     => $data['student_code'] ?: '12345678',
                        'first_name'   => $data['first_name'],
                        'last_name'    => $data['last_name'],
                        'faculty_id'   => $data['faculty_id'],
                        'class_id'     => $data['class_id'],
                        'role'         => 0,
                        'status'       => 'active',
                    ]);
                    $results['success']++;
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = ['row' => $rowNumber, 'messages' => [$e->getMessage()]];
                }
            }

            unset($csvFile);
            Storage::disk('local')->delete($path);

            return response()->json(['success' => true, 'results' => $results]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }
}
