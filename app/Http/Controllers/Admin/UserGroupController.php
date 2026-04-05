<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserGroupController extends Controller
{
    public function index()
    {
        // AC: Hiện danh sách và số lượng user trong nhóm
        $groups = UserGroup::withCount('users')->get();
        return view('admin.user_groups.index', compact('groups'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:user_groups,name|max:255',
            'description' => 'nullable'
        ]);

        UserGroup::create($request->all());
        return redirect()->back()->with('success', 'Thêm nhóm thành công!');
    }

    public function edit($id)
    {
        $group = UserGroup::findOrFail($id);
        return view('admin.user_groups.edit', compact('group'));
    }

    public function update(Request $request, $id)
    {
        $group = UserGroup::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:user_groups,name,' . $id,
        ]);

        $group->update($request->all());
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $group = UserGroup::withCount(['users', 'quizSchedules', 'quizzes'])->findOrFail($id);

        // AC: Kiểm tra nếu nhóm đang có user hoặc đang gán bài thi/lịch thi
        if ($group->users_count > 0 || $group->quizzes_count > 0 || $group->quiz_schedules_count > 0) {
            return redirect()->back()->with('error', 'Không thể xóa: Nhóm đang có thành viên hoặc đã được gán vào bài thi!');
        }

        $group->delete();
        return redirect()->back()->with('success', 'Xóa nhóm thành công!');
    }
}