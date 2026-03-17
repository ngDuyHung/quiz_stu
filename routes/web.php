<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chude2Controller;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use Illuminate\Support\Facades\Route;

// Auth Routes
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



