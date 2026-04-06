@extends('admin.dashboard')

@section('title', 'Chỉnh sửa Nhóm người dùng')

@section('content')
<div class="card-custom">
    <h2 class="mb-4"><i class="fas fa-user-shield"></i> Chỉnh sửa Nhóm người dùng</h2>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.user-groups.update', $group->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Tên nhóm <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $group->name) }}" placeholder="VD: Đầu khóa" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Mô tả chi tiết về nhóm này">{{ old('description', $group->description) }}</textarea>
                </div>

                <div class="mb-3 p-3 bg-light rounded">
                    <strong>Thông tin:</strong>
                    <p class="mb-0">Số thành viên: <span class="badge bg-info text-dark">{{ $group->users()->count() }}</span></p>
                    <p class="mb-0">Bài thi được gán: <span class="badge bg-success">{{ $group->quizzes()->count() }}</span></p>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <a href="{{ route('admin.user-groups.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
