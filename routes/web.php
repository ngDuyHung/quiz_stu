<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chude2Controller;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentListController;
use App\Http\Controllers\Admin\QuestionsandAnswersController;
use App\Http\Controllers\Admin\QuestionCategoryController;
use App\Http\Controllers\Admin\QuestionLevelController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Client\CourseController;
use App\Http\Controllers\Client\StudentQuizController;
use App\Http\Controllers\Client\ProfileController;

// 1. Redirect home to login
Route::get('/', function () {
    return redirect()->route('auth.login');
})->name('home');

// 2. Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// 3. Admin Routes (Cleaned & Optimized)
Route::middleware(['auth', 'admin.only'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Quản lý Sinh viên (Tái tích hợp Import)
    Route::prefix('students')->name('students.')->group(function() {
        Route::get('/download-template', [StudentListController::class, 'downloadTemplate'])->name('import-template');
        Route::post('/import', [StudentListController::class, 'import'])->name('import');
        Route::get('/classes-by-faculty', [StudentListController::class, 'getClassesByFaculty'])->name('classes-by-faculty');
        Route::post('/{student}/toggle-status', [StudentListController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{student}/reset-password', [StudentListController::class, 'resetPassword'])->name('reset-password');
    });
    Route::resource('students', StudentListController::class);

    // Quản lý Câu hỏi & Đáp án (Dùng bản mới của team)
    Route::resource('questions', QuestionsandAnswersController::class);
    Route::get('questions/{question}/options-count', [QuestionsandAnswersController::class, 'getOptionsCount'])->name('questions.options-count');
    Route::get('questions/{question}/stats', [QuestionsandAnswersController::class, 'getStats'])->name('questions.stats');

    // Quản lý đề thi & cơ cấu
    Route::resource('quizzes', QuizController::class);
    Route::resource('question-categories', QuestionCategoryController::class);
    Route::resource('question-levels', QuestionLevelController::class);
    Route::resource('faculties', \App\Http\Controllers\Admin\FacultyController::class);
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class);
    Route::resource('user-groups', \App\Http\Controllers\Admin\UserGroupController::class)->except(['create', 'show']);
    
    // Năm học
    Route::resource('years', \App\Http\Controllers\SchoolYearController::class);
    Route::post('/years/{year}/activate', [\App\Http\Controllers\SchoolYearController::class, 'activate'])->name('years.activate');
});

// 4. Client Routes
Route::middleware(['auth', 'client.only'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses');
    Route::get('/results', [StudentQuizController::class, 'history'])->name('results');
    Route::get('/ranking', function () { return view('client.ranking'); })->name('ranking');
    Route::get('/answer&question', function () { return view('client.answer&question'); })->name('answer&question');
    Route::get('/result-detail', function () { return view('client.result-detail'); })->name('result-detail');

    Route::get('/exams', [StudentQuizController::class, 'index'])->name('exams');
    Route::get('/history', [StudentQuizController::class, 'history'])->name('history');
    
    // Hồ sơ cá nhân
    Route::get('/profile',            [ProfileController::class, 'show'])->name('profile');
    Route::patch('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

    // Kỳ thi – làm bài
    Route::prefix('quiz')->name('quiz.')->group(function () {
        Route::get('/{quiz}/start',          [StudentQuizController::class, 'start'])->name('start');
        Route::get('/{quiz}/take/{result}',  [StudentQuizController::class, 'take'])->name('take');
        Route::post('/{result}/answer',      [StudentQuizController::class, 'saveAnswer'])->name('save-answer');
        Route::post('/{result}/submit',      [StudentQuizController::class, 'submit'])->name('submit');
        Route::get('/{result}/result',       [StudentQuizController::class, 'showResult'])->name('result');
        Route::post('/{result}/feedback',    [StudentQuizController::class, 'storeFeedback'])->name('feedback');
    });
});

Route::resource('chude2', Chude2Controller::class);
