<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Faculty;
use App\Models\UserGroup;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Throwable;

class StudentListController extends Controller
{
    /**
     * Import sinh viên từ CSV/Excel
     */
    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:10240',
        ]);

        try {
            $import = new StudentsImport;
            Excel::import($import, $request->file('file'));
            
            $failures = $import->failures();
            $successCount = $import->getRowCount();
            
            if ($failures->isNotEmpty()) {
                return back()->with('import_report', [
                    'success' => $successCount,
                    'failed' => $failures->count(),
                    'errors' => $failures
                ])->with('success', "Import hoàn tất với một số lỗi.");
            }

            return back()->with('success', "Import danh sách sinh viên thành công ({$successCount} dòng)!");

        } catch (Throwable $e) {
            Log::error("Import Error: " . $e->getMessage());
            return back()->with('danger', 'Lỗi hệ thống khi import: ' . $e->getMessage());
        }
    }

    /**
     * Tải file mẫu CSV
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/sample_students.csv');
        if (!file_exists($filePath)) {
            return back()->with('danger', 'Không tìm thấy file mẫu!');
        }
        return response()->download($filePath);
    }

    /**
     * Danh sách sinh viên kèm Tìm kiếm & Filter
     */
    public function index(Request $request)
    {
        $query = User::where('role', 0) // Chỉ lấy sinh viên
            ->with(['userGroup', 'schoolClass', 'faculty']);

        // --- Search (LIKE) ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_code', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        }

        // --- Filter ---
        $query->when($request->faculty_id, fn ($q) => $q->where('faculty_id', $request->faculty_id))
            ->when($request->class_id, fn ($q) => $q->where('class_id', $request->class_id))
            ->when($request->group_id, fn ($q) => $q->where('group_id', $request->group_id))
            ->when($request->status !== null, fn ($q) => $q->where('status', $request->status));

        $students = $query->paginate(15);

        $faculties = Faculty::all();
        $userGroups = UserGroup::all();
        $classes = SchoolClass::all();

        return view('admin.students.index', compact('students', 'faculties', 'userGroups', 'classes'));
    }

    /**
     * Show student details
     */
    public function show($id)
    {
        $student = User::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show create student form
     */
    public function create()
    {
        $faculties = Faculty::all();
        $userGroups = UserGroup::all();
        $classes = SchoolClass::all();

        return view('admin.students.create', compact('faculties', 'userGroups', 'classes'));
    }

    /**
     * Show edit student form
     */
    public function edit($id)
    {
        $student = User::findOrFail($id);
        $faculties = Faculty::all();
        $userGroups = UserGroup::all();
        $classes = SchoolClass::all();

        return view('admin.students.edit', compact('student', 'faculties', 'userGroups', 'classes'));
    }

    /**
     * API: Load danh sách lớp theo khoa (AJAX)
     */
    public function getClassesByFaculty(Request $request)
    {
        $classes = SchoolClass::where('faculty_id', $request->faculty_id)->get(['id', 'name']);
        return response()->json($classes);
    }

    /**
     * Thêm mới sinh viên
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_code' => 'required|unique:users,student_code',
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'faculty_id' => 'nullable',
            'class_id' => 'nullable',
            'group_id' => 'nullable',
            'phone' => 'nullable|regex:/^[0-9]{10,11}$/',
            'password' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Mặc định password là student_code
        $data['password'] = Hash::make($data['student_code']);
        $data['role'] = 0; // Role sinh viên
        $data['status'] = 1; // Active by default

        User::create($data);

        return redirect()->back()->with('success', 'Thêm sinh viên thành công!');
    }

    /**
     * Cập nhật thông tin
     */
    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $data = $request->validate([
            'student_code' => ['required', Rule::unique('users')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'nullable|regex:/^[0-9]{10,11}$/',
            'faculty_id' => 'nullable',
            'class_id' => 'nullable',
            'group_id' => 'nullable',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $student->update($data);
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    /**
     * Toggle Trạng thái (AJAX)
     */
    public function toggleStatus($student, Request $request)
    {
        $studentRecord = User::findOrFail($student);
        $studentRecord->status = !$studentRecord->status;
        $studentRecord->save();

        return response()->json(['success' => true, 'status' => $studentRecord->status]);
    }

    /**
     * Reset mật khẩu về mặc định
     */
    public function resetPassword($id)
    {
        $student = User::findOrFail($id);
        $student->password = Hash::make($student->student_code);
        $student->save();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã reset mật khẩu về mã sinh viên!'
            ]);
        }

        return redirect()->back()->with('success', 'Đã reset mật khẩu về mã sinh viên!');
    }

    /**
     * Xóa sinh viên
     */
    public function destroy($id)
    {
        $student = User::findOrFail($id);
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        $student->delete();

        return redirect()->back()->with('success', 'Đã xóa sinh viên!');
    }

}
