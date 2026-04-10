<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        // Sắp xếp theo ID hoặc Name để Admin dễ nhìn hơn
        $faculties = Faculty::orderBy('id', 'asc')->get();
        return view('admin.faculties.index', compact('faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:faculties,id|max:10', 
            'name' => 'required|max:100',
        ], [
            // Thêm thông báo tiếng Việt cho thân thiện
            'id.unique' => 'Mã khoa này đã tồn tại trong hệ thống!',
            'id.required' => 'Vui lòng nhập mã khoa.',
            'name.required' => 'Vui lòng nhập tên khoa.',
        ]);

        Faculty::create([
            'id' => strtoupper(trim($request->id)), 
            'name' => trim($request->name),// trim để xóa khoảng trắng thừa
        ]);

        return redirect()->route('admin.faculties.index')->with('success', 'Thêm khoa mới thành công!');
    }

    public function edit($id)
    {
        $faculty = Faculty::findOrFail($id);
        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
        ], [
            'name.required' => 'Tên khoa không được để trống.',
        ]);

        $faculty = Faculty::findOrFail($id);
        $faculty->update([
            'name' => trim($request->name)
        ]);

        return redirect()->route('admin.faculties.index')->with('success', 'Cập nhật thông tin khoa thành công!');
    }

    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id);
        
        if ($faculty->classes()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa vì Khoa này đang có lớp học!');
        }

        $faculty->delete();
        return redirect()->route('admin.faculties.index')->with('success', 'Đã xóa khoa thành công!');
    }
}