<?php

use App\Http\Controllers\Chude2Controller;
use Illuminate\Support\Facades\Route;


// đây là nơi định nghĩa các route cho ứng dụng .
// Route'/', sẽ định nghĩa một route GET cho đường dẫn gốc '/

// Route trang chủ
Route::get('/', [Chude2Controller::class, 'index'])->name('user.index'); 

// Route hiển thị form thêm
Route::get('/users/create', [Chude2Controller::class, 'create'])->name('user.create');

// Route xử lý lưu
Route::post('/users/store', [Chude2Controller::class, 'store'])->name('user.store');

 // nó sẽ gửi lên controller với hàm là index để xử lý tiếp ở đó)
Route::resource('chude2', Chude2Controller::class);



