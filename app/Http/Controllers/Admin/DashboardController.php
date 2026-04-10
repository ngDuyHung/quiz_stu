<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::count(); // nếu chưa phân role
        // nếu có role thì dùng:
        // User::where('role', 'student')->count();

        $totalQuizzes = Quiz::count();
        $totalQuestions = Question::count();
        $totalResults = QuizResult::count();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalQuizzes',
            'totalQuestions',
            'totalResults'
        ));
    }
}
