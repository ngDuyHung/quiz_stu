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


// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);

    // Đăng ký tài khoản (nếu cần)
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin.only'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Question Category management routes
    Route::resource('question-categories', QuestionCategoryController::class);

    // Question Level management routes
    Route::resource('question-levels', QuestionLevelController::class);

    // Questions and Answers management routes
    Route::resource('questions', \App\Http\Controllers\Admin\QuestionsandAnswersController::class);
    Route::get('questions/{question}/options-count', [\App\Http\Controllers\Admin\QuestionsandAnswersController::class, 'getOptionsCount'])->name('questions.options-count');
    Route::get('questions/{question}/stats', [\App\Http\Controllers\Admin\QuestionsandAnswersController::class, 'getStats'])->name('questions.stats');

    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class);

    // PHẦN QUẢN LÝ NĂM HỌC
    Route::post('years/{id}/activate', [\App\Http\Controllers\SchoolYearController::class, 'activate'])->name('years.activate');

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

// Client Routes
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
    Route::get('/exams', function () {
        return view('client.exams');
    })->name('exams');
});

// Redirect home to login
Route::get('/', function () {
    return redirect()->route('auth.login');
})->name('home');

// Route trang chủ (cũ)
Route::get('/chude2', [Chude2Controller::class, 'index'])->name('user.index');

// Route hiển thị form thêm
Route::get('/users/create', [Chude2Controller::class, 'create'])->name('user.create');

// Route xử lý lưu
Route::post('/users/store', [Chude2Controller::class, 'store'])->name('user.store');

Route::resource('chude2', Chude2Controller::class);

Route::prefix('admin')->group(function () {
    Route::get('/questions/index', [QuestionController::class, 'stats'])
        ->name('admin.questions.index');
});

Route::get(
    '/admin/users/index/{id}',
    [UsersController::class, 'index']
)->name('admin.users.index');
