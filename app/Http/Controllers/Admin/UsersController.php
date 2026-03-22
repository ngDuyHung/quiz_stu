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

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['faculty', 'schoolClass', 'userGroup'])
            ->where('role', 0); // Only students

// Search functionality
if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function($q) use ($search) {
        $q->where('student_code', 'LIKE', "%{$search}%")
          ->orWhere('email', 'LIKE', "%{$search}%")
          ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$search}%");
    });
}

// Filters
if ($request->filled('faculty_id')) {
    $query->where('faculty_id', $request->faculty_id);
}

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
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
            'phone' => 'nullable|string|max:20',
            'faculty_id' => 'required|exists:faculties,id',
            'class_id' => 'required|exists:classes,id',
            'group_id' => 'required|exists:user_groups,id',
            'birthdate' => 'nullable|date',
            'academic_year' => 'nullable|string|max:20',
            'degree_type' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->student_code); // Default password is student_code
        $data['role'] = 0; // Student role

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Thêm sinh viên thành công!');
    }

    public function show(User $user)
    {
        $user->load(['faculty', 'schoolClass', 'userGroup']);
        return view('admin.users.show', compact('user'));
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
            'phone' => 'nullable|string|max:20',
            'faculty_id' => 'required|exists:faculties,id',
            'class_id' => 'required|exists:classes,id',
            'group_id' => 'required|exists:user_groups,id',
            'birthdate' => 'nullable|date',
            'academic_year' => 'nullable|string|max:20',
            'degree_type' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật sinh viên thành công!');
    }

    public function destroy(User $user)
    {
        // Delete photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa sinh viên thành công!');
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