<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Lấy danh sách users
    public function index()
    {
        $users = User::all();
        // Trả về JSON kèm HTTP status code 200 (OK)
        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    // Thêm mới user
    public function store(Request $request)
    {
        // Ghi chú: Thực tế nên có $request->validate() ở đây
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo người dùng thành công',
            'data' => $user
        ], 201); // 201 là mã Created
    }

    // Lấy chi tiết 1 user
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy người dùng'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    // Cập nhật user
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy người dùng'], 404);
        }

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->password) {
            $user->password = $request->password;
        }
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công',
            'data' => $user
        ], 200);
    }

    // Xóa user
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy người dùng'], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công'
        ], 200);
    }
}