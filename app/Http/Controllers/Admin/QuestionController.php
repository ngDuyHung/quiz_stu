<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionCategory;
use App\Models\QuestionLevel;
use App\Models\Question;

class QuestionController extends Controller
{
    public function stats(Request $request){
    $query = DB::table('questions')
        ->join('question_categories', 'questions.category_id', '=', 'question_categories.id')
        ->join('question_levels', 'questions.level_id', '=', 'question_levels.id')
        ->where('times_served', '>', 0)
        ->select(
            'questions.id',
            DB::raw('LEFT(questions.content, 80) as content'),
            'question_categories.name as category',
            'question_levels.name as level',
            'times_served',
            'times_correct',
            'times_incorrect',
            DB::raw('(times_correct / times_served) * 100 as percent_correct'),
            DB::raw('(times_incorrect / times_served) * 100 as percent_incorrect')
        );

    // filter
    if ($request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->level_id) {
        $query->where('level_id', $request->level_id);
    }

    $questions = $query
        ->orderByDesc(DB::raw('times_incorrect / times_served'))
        ->limit(20)
        ->get();

    $categories = QuestionCategory::all();
    $levels = QuestionLevel::all();

    return view('admin.questions.index', compact('questions', 'categories', 'levels'));
    }
    public function index(Request $request)
    {
        // 1. Khởi tạo query với JOIN các bảng liên quan (AC: JOIN categories, levels)
        $query = \App\Models\Question::with(['category', 'level']);

        // 2. Search full-text theo content (AC: LIKE %keyword%)
        if ($request->has('search') && $request->search != '') {
            $query->where('content', 'LIKE', '%' . $request->search . '%');
        }

        // 3. Filter đa điều kiện: category + level + type (AC: kết hợp được)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('level_id')) {
            $query->where('level_id', $request->level_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 4. Pagination 20 câu/trang (AC: 10–20 câu/trang)
        $questions = $query->latest()->paginate(20);

        // 5. Xử lý Preview nội dung (AC: truncate 100 chars, strip HTML tags)
        $questions->getCollection()->transform(function ($question) {
            $question->preview = str(strip_tags($question->content))->limit(100);
            return $question;
        });

        $categories = \App\Models\QuestionCategory::all();
        $levels = \App\Models\QuestionLevel::all();

        return view('admin.questions.index', compact('questions', 'categories', 'levels'));
    }
}
