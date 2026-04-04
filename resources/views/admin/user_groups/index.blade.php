@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Quản lý Nhóm người dùng</h2>
    
    <form action="{{ route('admin.user-groups.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Tên nhóm (VD: Đầu khóa)" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="description" class="form-control" placeholder="Mô tả">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Thêm mới</button>
            </div>
        </div>
    </form>

    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên nhóm</th>
                <th>Mô tả</th>
                <th>Số TV</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{ $group->id }}</td>
                <td>{{ $group->name }}</td>
                <td>{{ $group->description }}</td>
                <td><span class="badge bg-info text-dark">{{ $group->users_count }}</span></td>
                <td>
                    <form action="{{ route('admin.user-groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection