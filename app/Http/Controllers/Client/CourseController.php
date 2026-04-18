<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\QuizResult;
use App\Models\ResultAnswer;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $filter = request()->get('filter', 'all'); // 'all', 'studying', 'completed'

        $results = QuizResult::with('quiz')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10); // Add pagination

        $courses = $results->map(function ($result) {
            return (object)[
                'id' => $result->id,
                'name' => $result->quiz?->name ?? 'Khóa học chưa có tên',
                'code' => $result->quiz?->code ?? sprintf('QZ-%03d', $result->quiz_id),
                'semester' => $result->quiz?->start_date?->format('m') ?? 1,
                'instructor_name' => 'Giảng viên STU',
                'credits' => $result->quiz?->duration_minutes ? round($result->quiz->duration_minutes / 15, 1) : 3.0,
                'progress' => (int) round($result->percentage ?? 0),
                'status' => $result->status === 'completed' ? 'completed' : 'studying',
                'icon' => $result->status === 'completed' ? 'verified' : 'terminal',
            ];
        });

        // Filter courses based on filter
        if ($filter === 'studying') {
            $courses = $courses->where('status', 'studying');
        } elseif ($filter === 'completed') {
            $courses = $courses->where('status', 'completed');
        }

        $stats = [
            'studying' => $courses->where('status', 'studying')->count(),
            'completed' => $courses->where('status', 'completed')->count(),
            'commits' => ResultAnswer::where('user_id', $user->id)->count(),
        ];

        return view('client.course', compact('courses', 'stats', 'filter', 'results'));
    }
}
