<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chude2Controller;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Client\CourseController;
use App\Http\Controllers\Admin\UserGroupController;
use App\Http\Controllers\Admin\QuestionCategoryController;
use App\Http\Controllers\Admin\QuestionLevelController;
use App\Http\Controllers\Admin\QuizController;
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

// Admin Routes
Route::middleware(['auth', 'admin.only'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Quản lý Users
    Route::prefix('users')->name('users.')->group(function() {
        Route::get('/download-template', [UsersController::class, 'downloadTemplate'])->name('import-template');
        Route::post('/import', [UsersController::class, 'import'])->name('import');
        Route::post('/{user}/toggle-status', [UsersController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{user}/reset-password', [UsersController::class, 'resetPassword'])->name('reset-password');
    });
    Route::resource('users', UsersController::class);

    Route::resource('quizzes', QuizController::class);

    Route::resource('questions', QuestionController::class); 

    Route::resource('question-categories', QuestionCategoryController::class);

    // Question Level management routes
    Route::resource('question-levels', QuestionLevelController::class);

    // Questions and Answers management routes
    Route::resource('questions', \App\Http\Controllers\Admin\QuestionsandAnswersController::class);
    Route::get('questions/{question}/options-count', [\App\Http\Controllers\Admin\QuestionsandAnswersController::class, 'getOptionsCount'])->name('questions.options-count');
    Route::get('questions/{question}/stats', [\App\Http\Controllers\Admin\QuestionsandAnswersController::class, 'getStats'])->name('questions.stats');

    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class);
    Route::resource('user-groups', UserGroupController::class);
    Route::resource('faculties', \App\Http\Controllers\Admin\FacultyController::class);
    Route::resource('years', \App\Http\Controllers\SchoolYearController::class);

    // User management routes
    Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UsersController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\Admin\UsersController::class, 'resetPassword'])->name('users.reset-password');

    // Faculty management routes

    Route::resource('faculties', \App\Http\Controllers\Admin\FacultyController::class);

    // User Group management routes
    Route::resource('user-groups', UserGroupController::class)->except(['create', 'show']);

    // Student management routes - custom routes first to take precedence
    Route::get('students/classes-by-faculty', [\App\Http\Controllers\Admin\StudentListController::class, 'getClassesByFaculty'])->name('students.classes-by-faculty');
    Route::post('students/{student}/toggle-status', [\App\Http\Controllers\Admin\StudentListController::class, 'toggleStatus'])->name('students.toggle-status');
    Route::post('students/{student}/reset-password', [\App\Http\Controllers\Admin\StudentListController::class, 'resetPassword'])->name('students.reset-password');
    
    Route::resource('students', \App\Http\Controllers\Admin\StudentListController::class);
});

// 4. Client Routes
Route::middleware(['auth', 'client.only'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses');
    Route::get('/results', function () {
        return view('client.result-detail');
    })->name('results');
    Route::get('/ranking', function () {
        return view('client.ranking');
    })->name('ranking');
    Route::get('/answer&question', function () {
        return view('client.answer&question');
    })->name('answer&question');
    Route::get('/result-detail', function () {
        return view('client.result-detail');
    })->name('result-detail');

    // Kỳ thi – danh sách
    Route::get('/exams', [StudentQuizController::class, 'index'])->name('exams');

    // Lịch sử thi
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

// 5. Các Route cũ/phụ (Nếu Duy còn dùng)
Route::resource('chude2', Chude2Controller::class);