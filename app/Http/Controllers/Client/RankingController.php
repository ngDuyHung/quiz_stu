<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all users with their average quiz scores
        $rankings = User::select(
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.student_code',
            'users.class_id',
            'users.photo',
            DB::raw('AVG(quiz_results.percentage) as avg_score')
        )
            ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
            ->where('users.role', 'student')
            ->groupBy(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.student_code',
                'users.class_id',
                'users.photo'
            )
            ->orderByDesc('avg_score')
            ->get()
            ->map(function ($user, $index) {
                return (object)[
                    'rank' => $index + 1,

                    // 🔥 ghép tên lại
                    'name' => $user->first_name . ' ' . $user->last_name,

                    'student_id' => $user->student_code,
                    'class' => $user->class_id,
                    'major' => 'CNTT', // nếu chưa có bảng major
                    'avg_score' => round($user->avg_score ?? 0, 1),

                    // 🔥 sửa avatar -> photo
                    'avatar' => $user->photo ?? 'https://i.pravatar.cc/150?u=' . $user->id,

                    'is_current_user' => $user->id === Auth::id(),
                ];
            });

        // Calculate stats
        $stats = [
            'highest_score' => $rankings->max('avg_score') ?? 0,
            'highest_name' => $rankings->where('avg_score', $rankings->max('avg_score'))->first()->name ?? 'N/A',
            'average_score' => round($rankings->avg('avg_score') ?? 0, 1),
            'total_students' => $rankings->count(),
            'current_user_rank' => $rankings->where('is_current_user', true)->first()->rank ?? null,
            'current_user_score' => $rankings->where('is_current_user', true)->first()->avg_score ?? 0,
        ];

        return view('client.ranking', compact('rankings', 'stats'));
    }
}
