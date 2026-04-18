<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionCategory;
use App\Models\QuestionLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsandAnswersController extends Controller
{
    /**
     * Danh sách câu hỏi kèm filter
     */
    public function index(Request $request)
    {
        $query = Question::with(['category', 'level', 'options']);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by level
        if ($request->filled('level_id')) {
            $query->where('level_id', $request->level_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search by content
        if ($request->filled('search')) {
            $query->where('content', 'LIKE', "%{$request->search}%");
        }

        $questions = $query->orderByDesc('created_at')->paginate(15);

        // Get filter options
        $categories = QuestionCategory::all();
        $levels = QuestionLevel::all();
        $types = ['single' => 'Một đáp án', 'multiple' => 'Nhiều đáp án', 'match' => 'Ghép cặp'];

        return view('admin.questions.index', compact('questions', 'categories', 'levels', 'types'));
    }

    /**
     * Show form create question
     */
    public function create()
    {
        $categories = QuestionCategory::all();
        $levels = QuestionLevel::all();
        $types = ['single' => 'Một đáp án', 'multiple' => 'Nhiều đáp án', 'match' => 'Ghép cặp'];

        return view('admin.questions.create', compact('categories', 'levels', 'types'));
    }

    /**
     * Store question
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:single,multiple,match',
            'content' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:question_categories,id',
            'level_id' => 'required|exists:question_levels,id',
            'options' => 'required|array|min:2',
            'options.*.content' => 'required|string',
            'options.*.match_text' => 'nullable|string',
            'options.*.is_correct' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Create question
            $question = Question::create([
                'type' => $validated['type'],
                'content' => $validated['content'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'level_id' => $validated['level_id'],
                'times_served' => 0,
                'times_correct' => 0,
                'times_incorrect' => 0,
            ]);

            // Create options
            $correctCount = 0;
            foreach ($request->options as $option) {
                if (empty($option['content'])) {
                    continue;
                }

                $isCorrect = isset($option['is_correct']) ? (bool)$option['is_correct'] : false;

                if ($isCorrect) {
                    $correctCount++;
                }

                // Validation: single type only 1 correct answer
                if ($validated['type'] === 'single' && $correctCount > 1) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Loại "Một đáp án" chỉ được có 1 đáp án đúng!');
                }

                QuestionOption::create([
                    'question_id' => $question->id,
                    'content' => $option['content'],
                    'match_text' => $option['match_text'] ?? null,
                    'is_correct' => $isCorrect,
                ]);
            }

            // Validation: single type must have exactly 1 correct answer
            if ($validated['type'] === 'single' && $correctCount !== 1) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Loại "Một đáp án" phải có đúng 1 đáp án đúng!');
            }

            // Validation: multiple type must have at least 2 correct answers
            if ($validated['type'] === 'multiple' && $correctCount < 2) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Loại "Nhiều đáp án" phải có ít nhất 2 đáp án đúng!');
            }

            DB::commit();
            return redirect()->route('admin.questions.index')
                ->with('success', 'Tạo câu hỏi thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Show question details
     */
    public function show($id)
    {
        $question = Question::with(['category', 'level', 'options'])->findOrFail($id);
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show form edit question
     */
    public function edit($id)
    {
        $question = Question::with('options')->findOrFail($id);
        $categories = QuestionCategory::all();
        $levels = QuestionLevel::all();
        $types = ['single' => 'Một đáp án', 'multiple' => 'Nhiều đáp án', 'match' => 'Ghép cặp'];

        return view('admin.questions.edit', compact('question', 'categories', 'levels', 'types'));
    }

    /**
     * Update question
     */
    public function update(Request $request, $id)
    {
        $question = Question::with('options')->findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:single,multiple,match',
            'content' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:question_categories,id',
            'level_id' => 'required|exists:question_levels,id',
            'options' => 'required|array|min:2',
            'options.*.content' => 'required|string',
            'options.*.match_text' => 'nullable|string',
            'options.*.is_correct' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Update question
            $question->update([
                'type' => $validated['type'],
                'content' => $validated['content'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'level_id' => $validated['level_id'],
            ]);

            // Delete old options that are marked for deletion
            $optionIds = collect($request->options)
                ->pluck('id')
                ->filter()
                ->values()
                ->toArray();

            QuestionOption::where('question_id', $question->id)
                ->whereNotIn('id', $optionIds)
                ->delete();

            // Update or create options
            $correctCount = 0;
            foreach ($request->options as $option) {
                if (empty($option['content'])) {
                    continue;
                }

                $isCorrect = isset($option['is_correct']) ? (bool)$option['is_correct'] : false;

                if ($isCorrect) {
                    $correctCount++;
                }

                // Validation: single type only 1 correct answer
                if ($validated['type'] === 'single' && $correctCount > 1) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Loại "Một đáp án" chỉ được có 1 đáp án đúng!');
                }

                if (isset($option['id']) && $option['id']) {
                    // Update existing option
                    QuestionOption::find($option['id'])->update([
                        'content' => $option['content'],
                        'match_text' => $option['match_text'] ?? null,
                        'is_correct' => $isCorrect,
                    ]);
                } else {
                    // Create new option
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'content' => $option['content'],
                        'match_text' => $option['match_text'] ?? null,
                        'is_correct' => $isCorrect,
                    ]);
                }
            }

            // Validation: single type must have exactly 1 correct answer
            if ($validated['type'] === 'single' && $correctCount !== 1) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Loại "Một đáp án" phải có đúng 1 đáp án đúng!');
            }

            // Validation: multiple type must have at least 2 correct answers
            if ($validated['type'] === 'multiple' && $correctCount < 2) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Loại "Nhiều đáp án" phải có ít nhất 2 đáp án đúng!');
            }

            DB::commit();
            return redirect()->route('admin.questions.index')
                ->with('success', 'Cập nhật câu hỏi thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Delete question
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete(); // CASCADE will delete options

        return redirect()->route('admin.questions.index')
            ->with('success', 'Xóa câu hỏi thành công!');
    }

    /**
     * API: Get options count for question
     */
    public function getOptionsCount($id)
    {
        $count = QuestionOption::where('question_id', $id)->count();
        return response()->json(['count' => $count]);
    }

    /**
     * API: Get stats for question
     */
    public function getStats($id)
    {
        $question = Question::findOrFail($id);
        $correctRate = $question->times_served > 0
            ? round(($question->times_correct / $question->times_served) * 100, 1)
            : 0;

        return response()->json([
            'times_served' => $question->times_served,
            'times_correct' => $question->times_correct,
            'times_incorrect' => $question->times_incorrect,
            'correct_rate' => $correctRate,
        ]);
    }
}
