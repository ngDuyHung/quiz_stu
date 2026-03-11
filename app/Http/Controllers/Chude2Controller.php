<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Chude2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     * đây là nơi ham index sẽ lấy tất cả dữ liệu từ bảng users và trả về view chude2.index với dữ liệu đó
     */
    public function index()
    {
        
        $users =User::all();
        return view('chude2', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * còn cái này là nơi ham create sẽ trả về view chude2.create để hiển thị form tạo mới người dùng
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * cái này thì là nơi ham store sẽ nhận dữ liệu từ form tạo mới người dùng, sau đó lưu dữ liệu đó vào bảng users trong cơ sở dữ liệu
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * cái là nơi ham show sẽ nhận một id của người dùng, sau đó lấy dữ liệu của người dùng đó từ bảng users và trả về view chi tiết chude2.show với dữ liệu đó
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * cái này là nơi ham edit sẽ nhận một id của người dùng, sau đó lấy dữ liệu của người dùng đó từ bảng users và trả về view chỉnh sửa chude2.edit với dữ liệu đó
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('chude2edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * cái này là nơi ham update sẽ nhận dữ liệu từ form chỉnh sửa người dùng, sau đó cập nhật dữ liệu đó vào bảng users trong cơ sở dữ liệu
     */
    public function update(Request $request, string $id)
{
    $user = User::find($id);

    if ($user) {
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
    }

    return redirect('/chude2');
}

    /**
     * Remove the specified resource from storage.
     * cái này là nơi ham destroy sẽ nhận một id của người dùng, sau đó xóa dữ liệu của người dùng đó khỏi bảng users trong cơ sở dữ liệu
     */
   public function destroy(string $id)
{
    $user = User::find($id);

    if ($user) {
        $user->delete();
    }

    return redirect('/chude2');
}
}
