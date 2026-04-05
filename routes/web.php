<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chude2Controller;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\UserGroupController;
use App\Http\Controllers\Admin\QuestionCategoryController;
use App\Http\Controllers\Admin\FacultyController as AdminFacultyController;

// ---------------------------------------------------------
// PUBLIC & AUTH ROUTES
// ---------------------------------------------------------
Route::get('/', function () {
    return redirect()->route('auth.login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// ---------------------------------------------------------
// ADMIN ROUTES (Thống nhất cho Dev A)
// ---------------------------------------------------------
Route::middleware(['auth', 'admin.only'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Quản lý Khoa & Lớp
    Route::resource('faculties', AdminFacultyController::class);
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class);

    // Quản lý Người dùng & Nhóm
    Route::resource('users', UsersController::class);
    Route::post('users/{user}/toggle-status', [UsersController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/{user}/reset-password', [UsersController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('user-groups', UserGroupController::class)->except(['create', 'show']);

    // Quản lý Câu hỏi & Danh mục
    Route::resource('questions', QuestionController::class); // Đổi từ get/index thành resource
    Route::resource('question-categories', QuestionCategoryController::class);

    // Quản lý Năm học
    Route::post('years/{id}/activate', [\App\Http\Controllers\SchoolYearController::class, 'activate'])->name('years.activate');
    Route::resource('years', \App\Http\Controllers\SchoolYearController::class);

    // Analytics (Tạo route giả để Sidebar không lỗi 500)
    Route::get('/analytics', fn() => view('admin.dashboard'))->name('results.index');
});

// ---------------------------------------------------------
// CLIENT ROUTES
// ---------------------------------------------------------
Route::middleware(['auth', 'client.only'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
});

// ---------------------------------------------------------
// CÁC ROUTE CŨ / TEST (Nên dọn dẹp sau khi xong dự án)
// ---------------------------------------------------------
Route::resource('chude2', Chude2Controller::class);