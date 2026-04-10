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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Throwable;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['faculty', 'schoolClass', 'userGroup'])
            ->where('role', 0); // Chỉ lấy sinh viên

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_code', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(15);
        $faculties = Faculty::all();
        $classes = SchoolClass::all();
        $groups = UserGroup::all();

        return view('admin.users.index', compact('users', 'faculties', 'classes', 'groups'));
    }

    public function create()
    {
        $faculties = Faculty::all();
        $groups = UserGroup::all();
        return view('admin.users.create', compact('faculties', 'groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_code' => 'required|unique:users,student_code',
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
            'class_id' => 'required|exists:classes,id',
            'group_id' => 'required|exists:user_groups,id',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->student_code);
        $data['role'] = 0;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'Thêm sinh viên thành công!');
    }

    public function edit(User $user)
    {
        $faculties = Faculty::all();
        $classes = SchoolClass::where('faculty_id', $user->faculty_id)->get();
        $groups = UserGroup::all();
        return view('admin.users.edit', compact('user', 'faculties', 'classes', 'groups'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'student_code' => ['required', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
            'class_id' => 'required|exists:classes,id',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();
        if ($request->hasFile('photo')) {
            if ($user->photo) Storage::disk('public')->delete($user->photo);
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật sinh viên thành công!');
    }

    public function destroy(User $user)
    {
        if ($user->photo) Storage::disk('public')->delete($user->photo);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa sinh viên thành công!');
    }

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
            $failedCount = $failures->count(); // Đếm tổng số lỗi (không gộp hàng)
            
            if ($failures->isNotEmpty()) {
                return back()->with('import_errors', $failures)
                             ->with('success_count', $successCount)
                             ->with('failed_count', $failedCount)
                             ->with('success', "Import hoàn tất. Thành công: {$successCount}, Thất bại: {$failedCount} lỗi.");
            }

            return back()->with('success', "Import danh sách sinh viên thành công ({$successCount} dòng)!")
                         ->with('success_count', $successCount);

        } catch (\Throwable $e) {
            Log::error("Import Error: " . $e->getMessage());
            return back()->with('danger', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/sample_students.csv');
        if (!file_exists($filePath)) {
            return back()->withErrors(['error' => 'Không tìm thấy file mẫu!']);
        }
        return response()->download($filePath);
    }

    public function toggleStatus(User $user)
    {
        $user->update(['status' => !$user->status]);
        return response()->json([
            'success' => true,
            'status' => $user->status,
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    }

    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make($user->student_code)]);
        return response()->json([
            'success' => true,
            'message' => 'Đặt lại mật khẩu thành công!'
        ]);
    }

    public function getClasses(Request $request)
    {
        $classes = SchoolClass::where('faculty_id', $request->faculty_id)->get();
        return response()->json($classes);
    }
}