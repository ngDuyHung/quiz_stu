<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;

class QuestionCategoryController extends Controller
{
    public function index()
    {
        // AC: Hiện danh mục và đếm số lượng câu hỏi (COUNT)
        $categories = QuestionCategory::withCount('questions')->get();

        // FIX: Đổi từ 'admin.question_categories.index' thành 'admin.categories.index'
        // Vì trong ảnh thư mục của bạn tên là 'categories'
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:question_categories,name|max:255'
        ]);

        QuestionCategory::create($request->all());
        
        return redirect()->back()->with('success', 'Thêm danh mục thành công!');
    }

    public function update(Request $request, $id)
    {
        $category = QuestionCategory::findOrFail($id);
        
        $request->validate([
            'name' => 'required|unique:question_categories,name,' . $id
        ]);
        
        $category->update($request->all());
        
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $category = QuestionCategory::findOrFail($id);
        
        // AC: Xóa sẽ CASCADE (Logic xóa nằm ở DB nhờ ON DELETE CASCADE)
        $category->delete();
        
        return redirect()->back()->with('success', 'Đã xóa danh mục và toàn bộ câu hỏi liên quan!');
    }
}