<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::latest()->paginate(10);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'duration_minutes' => 'required|integer|min:1',
            'pass_percent' => 'required|integer|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $this->processBooleanFields($data);

        Quiz::create($data);

        return redirect()->route('admin.quizzes.index')->with('success', 'Tạo bài thi thành công!');
    }

    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'name' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'duration_minutes' => 'required|integer|min:1',
            'pass_percent' => 'required|integer|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $this->processBooleanFields($data);

        $quiz->update($data);

        return redirect()->route('admin.quizzes.index')->with('success', 'Cập nhật bài thi thành công!');
    }

    public function destroy(Quiz $quiz)
    {
        try {
            DB::beginTransaction();
            // Cascade delete (nếu DB chưa config)
            $quiz->quizCategoryLevels()->delete();
            $quiz->userGroups()->detach();
            $quiz->quizResults()->delete();
            $quiz->delete();
            DB::commit();

            return redirect()->route('admin.quizzes.index')->with('success', 'Xóa bài thi thành công!');
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    private function processBooleanFields(&$data)
    {
        $booleanFields = ['show_answer', 'require_camera', 'shuffle_questions', 'require_login', 'is_demo'];
        foreach ($booleanFields as $field) {
            $data[$field] = isset($data[$field]);
        }
    }
}
