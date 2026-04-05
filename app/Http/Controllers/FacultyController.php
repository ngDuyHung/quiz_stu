<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Hiển thị danh sách Khoa (Acceptance Criteria 1)
     */
    public function index()
    {
        // Lấy danh sách khoa và đếm số lớp liên kết (classes_count)
        $faculties = Faculty::withCount('classes')->get();
        return view('admin.faculties.index', compact('faculties'));
    }

    /**
     * Lưu khoa mới (Acceptance Criteria 2)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:faculties,id|max:10', // Validate ID duy nhất, max 10 ký tự
            'name' => 'required|max:100'
        ], [
            'id.unique' => 'Mã khoa này đã tồn tại!',
            'id.max' => 'Mã khoa không được quá 10 ký tự.',
            'name.required' => 'Tên khoa không được để trống.'
        ]);

        Faculty::create($request->all());

        return redirect()->back()->with('success', 'Thêm khoa mới thành công!');
    }

    /**
     * Cập nhật tên khoa (Acceptance Criteria 3)
     */
    public function update(Request $request, string $id)
    {
        $faculty = Faculty::findOrFail($id);

        $request->validate([
            'name' => 'required|max:100'
        ], [
            'name.required' => 'Bạn phải nhập tên khoa mới.'
        ]);

        // CHỈ cập nhật name, ID giữ nguyên (Acceptance Criteria 3)
        $faculty->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.faculties.index')->with('success', 'Đã cập nhật tên khoa thành công!');
    }

    /**
     * Xóa khoa (Acceptance Criteria 4)
     */
    public function destroy(string $id)
    {
        $faculty = Faculty::findOrFail($id);

        // KIỂM TRA: Nếu khoa có ít nhất 1 lớp học
        if ($faculty->classes()->exists()) {
            // Trả về kèm thông báo lỗi (Flash message)
            return redirect()->back()->with('error', 'Không thể xóa! Khoa này đang có lớp học liên kết.');
        }

        $faculty->delete();
        return redirect()->back()->with('success', 'Đã xóa khoa thành công.');
    }

    // Các hàm show, edit, create có thể để trống nếu cậu dùng Modal hoặc làm chung 1 trang index
}