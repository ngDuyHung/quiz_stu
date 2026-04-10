<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('userGroup', 'schoolClass', 'faculty');
        $now  = now();

        $quizzes = Quiz::whereHas('userGroups', function ($q) use ($user) {
                $q->where('user_groups.id', $user->group_id);
            })
            ->with([
                'quizCategoryLevels',
                'quizResults' => function ($q) use ($user) {
                    $q->where('user_id', $user->id)->orderByDesc('created_at');
                },
            ])
            ->orderByRaw('CASE WHEN start_date IS NULL THEN 1 ELSE 0 END, start_date DESC')
            ->get()
            ->map(function ($quiz) use ($now) {
                $results = $quiz->quizResults;

                $quiz->open_result   = $results->firstWhere('status', 'open');
                $quiz->attempt_count = $results->whereIn('status', ['completed', 'expired'])->count();
                $quiz->total_questions = $quiz->quizCategoryLevels->sum('question_count');

                $quiz->is_upcoming = $quiz->start_date && $now->lt($quiz->start_date);
                $quiz->is_ended    = $quiz->end_date   && $now->gt($quiz->end_date);
                $quiz->is_active   = ! $quiz->is_upcoming && ! $quiz->is_ended;

                $quiz->can_start = $quiz->is_active
                    && ! $quiz->open_result
                    && (! $quiz->max_attempts || $quiz->attempt_count < $quiz->max_attempts);

                return $quiz;
            });

        $completedResults = $quizzes->flatMap(fn ($q) => $q->quizResults->where('status', 'completed'));

        $stats = [
            'active'    => $quizzes->where('is_active', true)->count(),
            'completed' => $completedResults->count(),
            'avg_score' => $completedResults->avg('percentage') ?? 0,
        ];

        $activeQuizzes   = $quizzes->where('is_active', true)->values();
        $upcomingQuizzes = $quizzes->where('is_upcoming', true)->values();

        return view('client.dashboard', compact('user', 'stats', 'activeQuizzes', 'upcomingQuizzes'));
    }
}
