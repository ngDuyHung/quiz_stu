<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionLevel;
use Illuminate\Http\Request;

class QuestionLevelController extends Controller
{
    /**
     * AC: Danh sách mức độ khó kèm đếm số câu hỏi đang dùng
     */
    public function index()
    {
        $levels = QuestionLevel::withCount('questions')->get();
        return view('admin.levels.index', compact('levels'));
    }

    /**
     * Thêm mức độ khó mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:question_levels,name|max:255'
        ]);

        QuestionLevel::create($request->all());
        
        return redirect()->back()->with('success', 'Thêm mức độ khó thành công!');
    }

    /**
     * Cập nhật mức độ khó
     */
    public function update(Request $request, $id)
    {
        $level = QuestionLevel::findOrFail($id);
        
        $request->validate([
            'name' => 'required|unique:question_levels,name,' . $id
        ]);
        
        $level->update($request->all());
        
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    /**
     * AC: Xóa mức độ khó
     * SET NULL ở questions.level_id → thông báo rõ hậu quả trước khi xóa
     */
    public function destroy($id)
    {
        $level = QuestionLevel::findOrFail($id);
        
        // Đếm số câu hỏi sẽ bị ảnh hưởng
        $questionsCount = $level->questions()->count();
        
        // Perform soft delete by setting level_id to NULL
        $level->questions()->update(['level_id' => null]);
        
        // Delete the level
        $level->delete();
        
        $message = "Đã xóa mức độ '{$level->name}'!";
        if ($questionsCount > 0) {
            $message .= " ({$questionsCount} câu hỏi đã được xóa khỏi mức độ này)";
        }
        
        return redirect()->back()->with('success', $message);
    }
}
