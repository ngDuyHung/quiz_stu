<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Faculty;
use App\Models\UserGroup;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Throwable;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('id', 'like', '%' . $request->search . '%');
        }
        $users = $query->paginate(10);
        
        $faculties = Faculty::all();
        $groups = UserGroup::all();
        $classes = User::distinct()->pluck('class_id')->filter();

        return view('admin.users.index', compact('users', 'faculties', 'groups', 'classes'));
    }

    // HÀM QUAN TRỌNG ĐANG THIẾU ĐÂY
    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:10240',
        ]);

        try {
            $import = new StudentsImport;
            Excel::import($import, $request->file('file'));
            
            $failures = $import->failures();
            if ($failures->isNotEmpty()) {
                return back()->with('import_errors', $failures);
            }

            return back()->with('success', 'Import danh sách sinh viên thành công!');
        } catch (Throwable $e) {
            Log::error("Import Error: " . $e->getMessage());
            return back()->withErrors(['error' => 'Lỗi hệ thống: ' . $e->getMessage()]);
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

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();
        return response()->json(['status' => $user->status]);
    }
}