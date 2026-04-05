<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Faculty;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Danh sách lớp học (Acceptance Criteria 1)
     */
    public function index(Request $request)
    {
        $faculties = Faculty::all(); // Lấy danh sách khoa cho Dropdown Filter
        
        // Bắt đầu query với Eager Loading 'faculty' để lấy tên Khoa (JOIN)
        $query = SchoolClass::with('faculty');

        // Logic Filter theo faculty_id (Nếu người dùng chọn lọc)
        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        $classes = $query->get();

        return view('admin.classes.index', compact('classes', 'faculties'));
    }

    /**
     * Lưu lớp học mới (Acceptance Criteria 2)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:classes,id|max:20', // Mã lớp duy nhất, VD: D22_TH01
            'name' => 'required|max:100',
            'faculty_id' => 'required|exists:faculties,id' // Phải thuộc một Khoa có thật
        ], [
            'id.unique' => 'Mã lớp này đã tồn tại!',
            'faculty_id.exists' => 'Khoa đã chọn không hợp lệ.'
        ]);

        SchoolClass::create($request->all());

        return redirect()->back()->with('success', 'Thêm lớp học thành công!');
    }

    /**
     * Cập nhật lớp học (Acceptance Criteria 3)
     */
    public function update(Request $request, string $id)
    {
        $class = SchoolClass::findOrFail($id);

        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|max:100' // Thêm name nếu  muốn cho sửa cả tên lớp
        ]);

        // CHỈ cập nhật faculty_id và name, giữ nguyên ID (Mã lớp)
        $class->update([
            'faculty_id' => $request->faculty_id,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Đã cập nhật thông tin lớp thành công!');
    }

    /**
     * Xóa lớp học (Acceptance Criteria 4)
     */
    public function destroy(string $id)
    {
        $class = SchoolClass::findOrFail($id);

        // KIỂM TRA: Nếu lớp đang có sinh viên thì không cho xóa
        if ($class->users()->exists()) {
            return redirect()->back()->with('error', 'Cảnh báo: Lớp này đang có sinh viên. Không thể xóa!');
        }

        $class->delete();

        return redirect()->back()->with('success', 'Đã xóa lớp học thành công.');
    }
}