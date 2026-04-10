<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizFeedback;
use App\Models\QuizResult;
use App\Models\ResultAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentQuizController extends Controller
{
    // ─────────────────────────────────────────────
    //  Lịch sử thi của sinh viên
    // ─────────────────────────────────────────────
    public function history()
    {
        $user = Auth::user();

        $results = QuizResult::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'expired'])
            ->with(['quiz'])
            ->orderByDesc('created_at')
            ->get();

        // Lấy result_id đã có feedback để tránh N+1
        $feedbackResultIds = QuizFeedback::where('user_id', $user->id)
            ->whereIn('result_id', $results->pluck('id'))
            ->pluck('result_id')
            ->flip(); // dùng như set

        $results = $results->map(function ($result) use ($feedbackResultIds) {
            $result->has_feedback = isset($feedbackResultIds[$result->id]);
            $passed = $result->quiz->pass_percent
                ? $result->percentage >= $result->quiz->pass_percent
                : null;
            $result->passed = $passed;
            return $result;
        });

        return view('client.history', compact('results'));
    }

    // ─────────────────────────────────────────────
    //  Danh sách bài thi của sinh viên
    // ─────────────────────────────────────────────
    public function index()
    {
        $user = Auth::user();
        $now  = now();

        $quizzes = Quiz::whereHas('userGroups', function ($q) use ($user) {
                $q->where('user_groups.id', $user->group_id);
            })
            ->with([
                'quizResults' => function ($q) use ($user) {
                    $q->where('user_id', $user->id)->orderByDesc('created_at');
                },
                'quizCategoryLevels',
            ])
            ->orderByDesc('start_date')
            ->get()
            ->map(function ($quiz) use ($now) {
                $results = $quiz->quizResults;

                $quiz->open_result      = $results->firstWhere('status', 'open');
                $quiz->attempt_count    = $results->where('status', 'completed')->count();
                $quiz->last_result      = $results->firstWhere('status', 'completed');
                $quiz->total_questions  = $quiz->quizCategoryLevels->sum('question_count');

                $quiz->is_upcoming = $quiz->start_date && $now->lt($quiz->start_date);
                $quiz->is_ended    = $quiz->end_date   && $now->gt($quiz->end_date);
                $quiz->is_active   = ! $quiz->is_upcoming && ! $quiz->is_ended;

                $quiz->can_start = $quiz->is_active
                    && ! $quiz->open_result
                    && (! $quiz->max_attempts || $quiz->attempt_count < $quiz->max_attempts);

                return $quiz;
            });

        // Stats for header cards
        $completedResults = $quizzes->flatMap(fn ($q) => $q->quizResults->where('status', 'completed'));
        $stats = [
            'active'    => $quizzes->where('is_active', true)->count(),
            'completed' => $completedResults->count(),
            'avg_score' => $completedResults->avg('percentage') ?? 0,
        ];

        return view('client.exams', compact('quizzes', 'stats'));
    }

    // ─────────────────────────────────────────────
    //  Bắt đầu làm bài – kiểm tra điều kiện, tạo record
    // ─────────────────────────────────────────────
    public function start(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $now  = now();

        // 1. Kiểm tra quyền truy cập theo nhóm
        if (! $quiz->userGroups()->where('user_groups.id', $user->group_id)->exists()) {
            return redirect()->route('client.exams')
                ->with('error', 'Bạn không có quyền truy cập bài thi này.');
        }

        // 2. Kiểm tra khung thời gian
        if ($quiz->start_date && $now->lt($quiz->start_date)) {
            return redirect()->route('client.exams')
                ->with('error', 'Bài thi chưa bắt đầu. Vui lòng quay lại sau.');
        }
        if ($quiz->end_date && $now->gt($quiz->end_date)) {
            return redirect()->route('client.exams')
                ->with('error', 'Bài thi đã kết thúc.');
        }

        // 3. Nếu đang có bài chưa nộp → tiếp tục bài cũ
        $openResult = QuizResult::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('status', 'open')
            ->first();

        if ($openResult) {
            return redirect()->route('client.quiz.take', [$quiz->id, $openResult->id]);
        }

        // 4. Kiểm tra số lượt
        if ($quiz->max_attempts) {
            $attemptCount = QuizResult::where('quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->whereIn('status', ['completed', 'expired'])
                ->count();

            if ($attemptCount >= $quiz->max_attempts) {
                return redirect()->route('client.exams')
                    ->with('error', 'Bạn đã hết lượt làm bài thi này.');
            }
        }

        // 5. Lấy cấu hình câu hỏi
        $categoryLevels = $quiz->quizCategoryLevels()->get();
        if ($categoryLevels->isEmpty()) {
            return redirect()->route('client.exams')
                ->with('error', 'Bài thi chưa được cấu hình câu hỏi. Vui lòng liên hệ giảng viên.');
        }

        // 6. Random câu hỏi theo từng (category × level)
        $selectedQuestions = collect();
        foreach ($categoryLevels as $cl) {
            $query = Question::where('category_id', $cl->category_id);
            if ($cl->level_id) {
                $query->where('level_id', $cl->level_id);
            }
            $selectedQuestions = $selectedQuestions->merge(
                $query->inRandomOrder()->limit($cl->question_count)->get()
            );
        }

        if ($selectedQuestions->isEmpty()) {
            return redirect()->route('client.exams')
                ->with('error', 'Không tìm thấy câu hỏi phù hợp cho bài thi này.');
        }

        // 7. Xáo trộn thứ tự câu hỏi nếu cần
        if ($quiz->shuffle_questions) {
            $selectedQuestions = $selectedQuestions->shuffle();
        }

        // 8. Tạo quiz_result + result_answers trong transaction
        $result = null;
        DB::transaction(function () use ($quiz, $user, $request, $selectedQuestions, &$result) {
            $result = QuizResult::create([
                'quiz_id'    => $quiz->id,
                'user_id'    => $user->id,
                'status'     => 'open',
                'started_at' => now(),
                'ip_address' => $request->ip(),
            ]);

            foreach ($selectedQuestions as $question) {
                ResultAnswer::create([
                    'result_id'   => $result->id,
                    'question_id' => $question->id,
                    'user_id'     => $user->id,
                    'score'       => 0,
                ]);
            }
        });

        return redirect()->route('client.quiz.take', [$quiz->id, $result->id]);
    }

    // ─────────────────────────────────────────────
    //  Giao diện làm bài
    // ─────────────────────────────────────────────
    public function take(Quiz $quiz, QuizResult $result)
    {
        $user = Auth::user();

        // Kiểm tra quyền sở hữu
        if ($result->user_id !== $user->id || $result->quiz_id !== $quiz->id) {
            abort(403);
        }

        if ($result->status !== 'open') {
            return redirect()->route('client.exams')
                ->with('info', 'Bài thi này đã được nộp rồi.');
        }

        // Kiểm tra hết giờ (server-side)
        $elapsedSeconds   = (int) now()->diffInSeconds($result->started_at);
        $totalSeconds     = $quiz->duration_minutes * 60;
        $remainingSeconds = max(0, $totalSeconds - $elapsedSeconds);

        if ($remainingSeconds <= 0) {
            $this->doSubmit($result, $quiz, 'expired');
            return redirect()->route('client.exams')
                ->with('info', 'Bài thi đã hết giờ và được nộp tự động.');
        }

        // Tải câu hỏi (giữ đúng thứ tự đã random khi tạo)
        $resultAnswers = $result->resultAnswers()
            ->with(['question.options'])
            ->orderBy('id')
            ->get();

        // Xáo trộn đáp án deterministic theo result_id + question_id
        if ($quiz->shuffle_questions) {
            $resultAnswers = $resultAnswers->map(function ($ra) use ($result) {
                $seed = ((int) $result->id) ^ ((int) $ra->question_id);
                $shuffled = $ra->question->options
                    ->sortBy(fn ($opt) => crc32((string) $seed . (string) $opt->id))
                    ->values();
                $ra->question->setRelation('options', $shuffled);
                return $ra;
            });
        }

        // Map dữ liệu cho JS – KHÔNG tiết lộ is_correct
        $questionsData = $resultAnswers->map(fn ($ra) => [
            'ra_id'              => $ra->id,
            'question_id'        => $ra->question_id,
            'content'            => $ra->question->content,
            'options'            => $ra->question->options->map(fn ($opt) => [
                'id'      => $opt->id,
                'content' => $opt->content,
            ])->values(),
            'selected_option_id' => $ra->selected_option_id,
        ])->values();

        return view('client.quizzes.take', compact('quiz', 'result', 'questionsData', 'remainingSeconds'));
    }

    // ─────────────────────────────────────────────
    //  Lưu đáp án (AJAX) – luôn UPDATE, không INSERT
    // ─────────────────────────────────────────────
    public function saveAnswer(Request $request, QuizResult $result)
    {
        $user = Auth::user();

        if ($result->user_id !== $user->id || $result->status !== 'open') {
            return response()->json(['success' => false, 'message' => 'Không có quyền.'], 403);
        }

        // Kiểm tra hết giờ server-side
        $elapsed = (int) now()->diffInSeconds($result->started_at);
        if ($elapsed > $result->quiz->duration_minutes * 60 + 30) { // +30s grace
            return response()->json(['success' => false, 'message' => 'Bài thi đã hết giờ.'], 410);
        }

        $validated = $request->validate([
            'question_id' => 'required|integer|exists:questions,id',
            'option_id'   => 'nullable|integer|exists:question_options,id',
        ]);

        // Chỉ UPDATE – không cho phép tạo mới record ngoài danh sách câu hỏi đề thi
        $affected = ResultAnswer::where('result_id', $result->id)
            ->where('question_id', $validated['question_id'])
            ->update([
                'selected_option_id' => $validated['option_id'] ?? null,
                'answered_at'        => now(),
            ]);

        if ($affected === 0) {
            return response()->json(['success' => false, 'message' => 'Câu hỏi không thuộc bài thi này.'], 422);
        }

        $answeredCount = ResultAnswer::where('result_id', $result->id)
            ->whereNotNull('selected_option_id')
            ->count();

        return response()->json([
            'success'        => true,
            'answered_count' => $answeredCount,
        ]);
    }

    // ─────────────────────────────────────────────
    //  Nộp bài
    // ─────────────────────────────────────────────
    public function submit(Request $request, QuizResult $result)
    {
        $user = Auth::user();

        if ($result->user_id !== $user->id) {
            abort(403);
        }

        if ($result->status !== 'open') {
            return redirect()->route('client.exams')
                ->with('info', 'Bài thi này đã được nộp rồi.');
        }

        // Lưu ảnh webcam (base64)
        if ($request->filled('photo_proof_base64')) {
            $photoData = $request->input('photo_proof_base64');
            if (preg_match('#^data:image/(\w+);base64,#', $photoData, $type)) {
                $ext      = strtolower($type[1]);
                $allowed  = ['jpeg', 'jpg', 'png', 'webp'];
                if (in_array($ext, $allowed, true)) {
                    $data     = base64_decode(substr($photoData, strpos($photoData, ',') + 1));
                    $filename = 'photo_proofs/' . $result->id . '_' . time() . '.' . $ext;
                    Storage::disk('public')->put($filename, $data);
                    $result->photo_proof = $filename;
                    $result->saveQuietly();
                }
            }
        }

        $quiz = $result->quiz;
        $this->doSubmit($result, $quiz);

        return redirect()->route('client.quiz.result', $result->id)
            ->with('success', 'Nộp bài thành công!');
    }

    // ─────────────────────────────────────────────
    //  Public helper — gọi được từ Artisan command
    // ─────────────────────────────────────────────
    public function expireResult(QuizResult $result): void
    {
        if ($result->status !== 'open') {
            return;
        }
        $this->doSubmit($result, $result->quiz, 'expired');
    }

    // ─────────────────────────────────────────────
    //  Tính điểm và đóng bài thi
    // ─────────────────────────────────────────────
    private function doSubmit(QuizResult $result, Quiz $quiz, string $status = 'completed'): void
    {
        // Load category-level configs (score_correct / score_incorrect)
        $categoryLevels = $quiz->quizCategoryLevels()->get();

        // Load tất cả đáp án kèm câu hỏi + option đã chọn
        $resultAnswers = $result->resultAnswers()
            ->with(['question', 'selectedOption'])
            ->get();

        $totalScore    = 0.0;
        $totalMaxScore = 0.0;
        $totalCorrect  = 0;

        // Batch counters cho questions: [question_id => [served, correct, incorrect]]
        $questionStats = [];

        foreach ($resultAnswers as $ra) {
            $question = $ra->question;

            // Tìm config điểm: ưu tiên khớp category + level, fallback category-only
            $cl = $categoryLevels->first(
                fn ($c) => $c->category_id == $question->category_id
                    && $c->level_id == $question->level_id
            ) ?? $categoryLevels->first(
                fn ($c) => $c->category_id == $question->category_id
                    && is_null($c->level_id)
            );

            if (! $cl) {
                continue;
            }

            $scoreCorrect   = (float) $cl->score_correct;
            $scoreIncorrect = (float) $cl->score_incorrect;

            $totalMaxScore += $scoreCorrect;

            // Đáng số thống kê câu hỏi
            $qid = $question->id;
            if (! isset($questionStats[$qid])) {
                $questionStats[$qid] = ['served' => 1, 'correct' => 0, 'incorrect' => 0];
            }

            if ($ra->selected_option_id && $ra->selectedOption?->is_correct) {
                // Trả lời đúng
                $score = $scoreCorrect;
                $totalCorrect++;
                $questionStats[$qid]['correct']++;
            } elseif ($ra->selected_option_id) {
                // Trả lời sai
                $score = -abs($scoreIncorrect);
                $questionStats[$qid]['incorrect']++;
            } else {
                // Bỏ qua
                $score = 0.0;
            }

            $ra->update(['score' => $score]);
            $totalScore += $score;
        }

        // Tính percentage = score đạt / tổng điểm tối đa
        $finalScore = max(0.0, round($totalScore, 2));
        $percentage = $totalMaxScore > 0
            ? round(($finalScore / $totalMaxScore) * 100, 2)
            : 0.0;

        $endedAt        = now();
        $elapsedSeconds = (int) $endedAt->diffInSeconds($result->started_at);

        $result->update([
            'status'        => $status,
            'ended_at'      => $endedAt,
            'total_seconds' => $elapsedSeconds,
            'score'         => $finalScore,
            'percentage'    => $percentage,
        ]);

        // Cập nhật thống kê câu hỏi (batch – tránh N query)
        foreach ($questionStats as $qid => $stat) {
            DB::table('questions')
                ->where('id', $qid)
                ->update([
                    'times_served'    => DB::raw('times_served + ' . $stat['served']),
                    'times_correct'   => DB::raw('times_correct + ' . $stat['correct']),
                    'times_incorrect' => DB::raw('times_incorrect + ' . $stat['incorrect']),
                ]);
        }
    }

    // ─────────────────────────────────────────────
    //  Trang kết quả bài thi
    // ─────────────────────────────────────────────
    public function showResult(QuizResult $result)
    {
        $user = Auth::user();

        if ($result->user_id !== $user->id) {
            abort(403);
        }

        if ($result->status === 'open') {
            return redirect()->route('client.quiz.take', [$result->quiz_id, $result->id]);
        }

        $quiz = $result->quiz;

        // Đếm số lần đã hoàn thành để kiểm tra "Làm lại"
        $attemptCount = QuizResult::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'expired'])
            ->count();

        $canRetry = $quiz->is_active_now
            ?? ($quiz->start_date ? now()->gte($quiz->start_date) : true)
            && ($quiz->end_date   ? now()->lte($quiz->end_date)   : true)
            && (! $quiz->max_attempts || $attemptCount < $quiz->max_attempts);

        // Kiểm tra thực tế (không dùng accessor)
        $now = now();
        $isActive = (! $quiz->start_date || $now->gte($quiz->start_date))
            && (! $quiz->end_date || $now->lte($quiz->end_date));
        $canRetry = $isActive
            && (! $quiz->max_attempts || $attemptCount < $quiz->max_attempts);

        // Kiểm tra đã gửi phản hồi chưa
        $hasFeedback = QuizFeedback::where('result_id', $result->id)
            ->where('user_id', $user->id)
            ->exists();

        // Tải đáp án kèm câu hỏi + tất cả options (để hiển thị review)
        $resultAnswers = $result->resultAnswers()
            ->with(['question.options', 'selectedOption'])
            ->orderBy('id')
            ->get();

        // Tính thống kê theo danh mục
        $categoryStats = [];
        if ($quiz->show_answer) {
            foreach ($resultAnswers as $ra) {
                $catName = $ra->question->category->name ?? 'Khác';
                if (! isset($categoryStats[$catName])) {
                    $categoryStats[$catName] = ['total' => 0, 'correct' => 0];
                }
                $categoryStats[$catName]['total']++;
                if ($ra->selected_option_id && $ra->selectedOption?->is_correct) {
                    $categoryStats[$catName]['correct']++;
                }
            }
        }

        $passed       = $result->percentage >= $quiz->pass_percent;
        $totalSeconds = $result->total_seconds ?? 0;
        $timeTaken    = sprintf('%02d:%02d', intdiv($totalSeconds, 60), $totalSeconds % 60);

        return view('client.result-detail', compact(
            'result', 'quiz', 'resultAnswers',
            'categoryStats', 'passed', 'timeTaken',
            'canRetry', 'hasFeedback'
        ));
    }

    // ─────────────────────────────────────────────
    //  Lưu phản hồi bài thi
    // ─────────────────────────────────────────────
    public function storeFeedback(Request $request, QuizResult $result)
    {
        $user = Auth::user();

        if ($result->user_id !== $user->id) {
            abort(403);
        }

        if ($result->status === 'open') {
            abort(403);
        }

        // Chỉ cho phép gửi 1 lần
        if (QuizFeedback::where('result_id', $result->id)->where('user_id', $user->id)->exists()) {
            return redirect()->route('client.quiz.result', $result->id)
                ->with('info', 'Bạn đã gửi phản hồi cho bài thi này rồi.');
        }

        $validated = $request->validate([
            'formality_score'  => 'required|integer|min:1|max:5',
            'time_score'       => 'required|integer|min:1|max:5',
            'content_score'    => 'required|integer|min:1|max:5',
            'presenter_score'  => 'required|integer|min:1|max:5',
            'suggestion'       => 'nullable|string|max:1000',
        ]);

        QuizFeedback::create([
            'user_id'         => $user->id,
            'result_id'       => $result->id,
            'formality_score' => $validated['formality_score'],
            'time_score'      => $validated['time_score'],
            'content_score'   => $validated['content_score'],
            'presenter_score' => $validated['presenter_score'],
            'suggestion'      => $validated['suggestion'] ?? null,
        ]);

        return redirect()->route('client.quiz.result', $result->id)
            ->with('success', 'Cảm ơn bạn đã gửi phản hồi!');
    }
}
