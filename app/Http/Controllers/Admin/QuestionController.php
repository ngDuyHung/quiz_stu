<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionCategory;
use App\Models\QuestionLevel;

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
}
