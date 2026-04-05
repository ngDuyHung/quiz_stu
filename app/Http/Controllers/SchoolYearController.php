<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolYearController extends Controller
{
    public function index()
    {
        // Sắp xếp năm mới nhất lên đầu
        $years = SchoolYear::orderBy('year', 'desc')->orderBy('semester', 'desc')->get();
        return view('admin.years.index', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => [
                'required', 
                'regex:/^\d{4}-\d{4}$/',
                // Logic: Kiểm tra cột 'year' trong bảng 'school_years'
                
                \Illuminate\Validation\Rule::unique('school_years')->where(function ($query) use ($request) {
                    // Điều kiện: Chỉ báo lỗi nếu CẢ year VÀ semester đều trùng
                    return $query->where('semester', $request->semester);
                }),
            ],
            'semester' => 'required|in:1,2',
        ], [
            'year.required' => 'Vui lòng nhập năm học.',
            'year.regex'    => 'Năm học phải có định dạng XXXX-XXXX (VD: 2025-2026).',
            'year.unique'   => 'Học kỳ ' . $request->semester . ' của năm học ' . $request->year . ' đã tồn tại!',
            'semester.in'   => 'Học kỳ không hợp lệ.'
        ]);

        \App\Models\SchoolYear::create($request->all());

        return redirect()->back()->with('success', 'Thêm năm học mới thành công!');
    }

    // Hàm tùy chỉnh để kích hoạt học kỳ (Duy cần thêm Route cho cái này ở Bước 2)
    public function activate($id)
    {
        DB::transaction(function () use ($id) {
            // Tắt tất cả các kỳ khác
            SchoolYear::where('is_active', 1)->update(['is_active' => 0]);
            
            // Kích hoạt kỳ hiện tại
            $year = SchoolYear::findOrFail($id);
            $year->update(['is_active' => 1]);
        });

        return redirect()->back()->with('success', 'Đã thay đổi học kỳ hoạt động!');
    }

    public function destroy(string $id)
    {
        $year = SchoolYear::findOrFail($id);

        // Acceptance Criteria 4: Không cho xóa năm học đang active
        if ($year->is_active) {
            return redirect()->back()->with('error', 'Không thể xóa học kỳ đang hoạt động!');
        }

        $year->delete();
        return redirect()->back()->with('success', 'Đã xóa năm học thành công.');
    }
}