<?php

use App\Http\Controllers\Chude2Controller;
use Illuminate\Support\Facades\Route;


// đây là nơi định nghĩa các route cho ứng dụng .
// Route'/', sẽ định nghĩa một route GET cho đường dẫn gốc '/
Route::get('/', [Chude2Controller::class, 'index']); // nó sẽ gửi lên controller với hàm là index để xử lý tiếp ở đó)
Route::resource('chude2', Chude2Controller::class);


// tương tự ae tập điền luôn tui demo tên hàm route thôi

// /users -> lấy tât cả users

// /users/1 -> lấy users có id=1

// làm thêm cho cả sửa, xóa nữa nhé
