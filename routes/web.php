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
use App\Http\Controllers\Admin\QuizController;


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
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class);
    Route::resource('user-groups', UserGroupController::class);
    Route::resource('faculties', \App\Http\Controllers\Admin\FacultyController::class);
    Route::resource('years', \App\Http\Controllers\SchoolYearController::class);

    Route::get('/question-levels', function() { return "Chức năng đang phát triển"; })->name('question-levels.index');
});

// 4. Client Routes
Route::middleware(['auth', 'client.only'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/answer&question', function () {
        return view('client.answer&question');
    })->name('answer&question');
    Route::get('/result-detail', function () {
        return view('client.result-detail');
    })->name('result-detail');
});

// 5. Các Route cũ/phụ (Nếu Duy còn dùng)
Route::resource('chude2', Chude2Controller::class);