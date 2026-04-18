<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\UserGroup;
use App\Models\QuestionCategory;
use App\Models\QuestionLevel;
use App\Models\QuizCategoryLevel;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount(['userGroups', 'quizCategoryLevels'])->latest()->paginate(10);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $userGroups = UserGroup::all();
        $categories = QuestionCategory::all();
        $levels = QuestionLevel::all();
        return view('admin.quizzes.create', compact('userGroups', 'categories', 'levels'));
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
            'group_ids' => 'required|array',
            'configs' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $this->processBooleanFields($data);
            
            $quiz = Quiz::create($data);
            $quiz->userGroups()->sync($request->group_ids);

            $warningMsg = "";
            foreach ($request->configs as $config) {
                if (isset($config['question_count']) && $config['question_count'] > 0) {
                    $bankCount = Question::where('category_id', $config['category_id']);
                    if (!empty($config['level_id'])) {
                        $bankCount->where('level_id', $config['level_id']);
                    }
                    $available = $bankCount->count();

                    if ($available < $config['question_count']) {
                        $catName = QuestionCategory::find($config['category_id'])->name;
                        $warningMsg .= " Danh mục '$catName' chỉ có $available câu nhưng yêu cầu $config[question_count] câu.";
                    }

                    QuizCategoryLevel::create([
                        'quiz_id' => $quiz->id,
                        'category_id' => $config['category_id'],
                        'level_id' => $config['level_id'] ?: null,
                        'question_count' => $config['question_count'],
                        'score_correct' => $config['score_correct'] ?? 0,
                        'score_incorrect' => $config['score_incorrect'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            $msg = 'Tạo bài thi thành công!';
            if ($warningMsg) {
                return redirect()->route('admin.quizzes.index')->with('warning', $msg . " Lưu ý: $warningMsg");
            }
            return redirect()->route('admin.quizzes.index')->with('success', $msg);
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit(Quiz $quiz)
    {
        $userGroups = UserGroup::all();
        $categories = QuestionCategory::all();
        $levels = QuestionLevel::all();
        $quiz->load(['userGroups', 'quizCategoryLevels']);
        
        return view('admin.quizzes.edit', compact('quiz', 'userGroups', 'categories', 'levels'));
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
            'group_ids' => 'required|array',
            'configs' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $this->processBooleanFields($data);

            $quiz->update($data);
            $quiz->userGroups()->sync($request->group_ids);

            $warningMsg = "";
            $quiz->quizCategoryLevels()->delete();
            foreach ($request->configs as $config) {
                if (isset($config['question_count']) && $config['question_count'] > 0) {
                    $bankCount = Question::where('category_id', $config['category_id']);
                    if (!empty($config['level_id'])) {
                        $bankCount->where('level_id', $config['level_id']);
                    }
                    $available = $bankCount->count();

                    if ($available < $config['question_count']) {
                        $catName = QuestionCategory::find($config['category_id'])->name;
                        $warningMsg .= " Danh mục '$catName' chỉ có $available câu nhưng yêu cầu $config[question_count] câu.";
                    }

                    QuizCategoryLevel::create([
                        'quiz_id' => $quiz->id,
                        'category_id' => $config['category_id'],
                        'level_id' => $config['level_id'] ?: null,
                        'question_count' => $config['question_count'],
                        'score_correct' => $config['score_correct'] ?? 0,
                        'score_incorrect' => $config['score_incorrect'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            $msg = 'Cập nhật bài thi thành công!';
            if ($warningMsg) {
                return redirect()->route('admin.quizzes.index')->with('warning', $msg . " Lưu ý: $warningMsg");
            }
            return redirect()->route('admin.quizzes.index')->with('success', $msg);
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function destroy(Quiz $quiz)
    {
        try {
            DB::beginTransaction();
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
