@extends('layouts.admin') {{-- Sử dụng trực tiếp file dashboard làm layout --}}

@section('title', 'Quản lý Nhóm người dùng')

@section('content')
<div class="card-custom">
    <h2 class="mb-4"><i class="fas fa-user-shield"></i> Quản lý Nhóm người dùng</h2>
    
    <div class="mb-4 p-3 bg-light rounded border">
        <form action="{{ route('admin.user-groups.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Tên nhóm (VD: Đầu khóa)" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="description" class="form-control" placeholder="Mô tả nhóm">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">➕ Thêm mới</button>
                </div>
            </div>
        </form>
    </div>

    @if(session('error')) 
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div> 
    @endif
    @if(session('success')) 
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div> 
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th width="80">ID</th>
                    <th>Tên nhóm</th>
                    <th>Mô tả</th>
                    <th class="text-center">Số TV</th>
                    <th width="120" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groups as $group)
                <tr>
                    <td>{{ $group->id }}</td>
                    <td><strong>{{ $group->name }}</strong></td>
                    <td>{{ $group->description ?? '...' }}</td>
                    <td class="text-center">
                        <span class="badge bg-info text-dark">{{ $group->users_count }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.user-groups.edit', $group->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.user-groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhóm này?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Chưa có nhóm người dùng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection