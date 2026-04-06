<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chude2Controller;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UsersController;

use App\Http\Controllers\Admin\UserGroupController;
use App\Http\Controllers\Admin\QuestionCategoryController;


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
});

// Client Routes
Route::middleware(['auth', 'client.only'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
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

Route::get('/admin/users/index/{id}', 
    [UsersController::class, 'index']
)->name('admin.users.index');


