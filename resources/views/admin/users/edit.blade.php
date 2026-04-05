@extends('layouts.admin')

@section('title', 'Chỉnh sửa sinh viên')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa thông tin sinh viên</h3>
                </div>

                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_code">Mã số sinh viên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('student_code') is-invalid @enderror"
                                           id="student_code" name="student_code" value="{{ old('student_code', $user->student_code) }}" required>
                                    @error('student_code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">Họ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birthdate">Ngày sinh</label>
                                    <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                           id="birthdate" name="birthdate" value="{{ old('birthdate', $user->birthdate ? $user->birthdate->format('Y-m-d') : '') }}">
                                    @error('birthdate')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="faculty_id">Khoa <span class="text-danger">*</span></label>
                                    <select class="form-control @error('faculty_id') is-invalid @enderror"
                                            id="faculty_id" name="faculty_id" required onchange="loadClasses()">
                                        <option value="">Chọn khoa</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}" {{ old('faculty_id', $user->faculty_id) == $faculty->id ? 'selected' : '' }}>
                                                {{ $faculty->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('faculty_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="class_id">Lớp <span class="text-danger">*</span></label>
                                    <select class="form-control @error('class_id') is-invalid @enderror"
                                            id="class_id" name="class_id" required>
                                        <option value="">Chọn lớp</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id', $user->class_id) == $class->id ? 'selected' : '' }}>
                                                {{ $class->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="group_id">Nhóm <span class="text-danger">*</span></label>
                                    <select class="form-control @error('group_id') is-invalid @enderror"
                                            id="group_id" name="group_id" required>
                                        <option value="">Chọn nhóm</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" {{ old('group_id', $user->group_id) == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ old('status', $user->status) === 0 ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="academic_year">Năm học</label>
                                    <input type="text" class="form-control @error('academic_year') is-invalid @enderror"
                                           id="academic_year" name="academic_year" value="{{ old('academic_year', $user->academic_year) }}"
                                           placeholder="Ví dụ: 2022-2026">
                                    @error('academic_year')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="degree_type">Loại bằng</label>
                                    <input type="text" class="form-control @error('degree_type') is-invalid @enderror"
                                           id="degree_type" name="degree_type" value="{{ old('degree_type', $user->degree_type) }}"
                                           placeholder="Ví dụ: Đại học">
                                    @error('degree_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="photo">Ảnh đại diện</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror"
                                           id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                                    <label class="custom-file-label" for="photo">Chọn file ảnh</label>
                                </div>
                            </div>
                            @error('photo')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                            <div class="mt-2">
                                @if($user->photo)
                                    <img id="photoPreview" src="{{ asset('storage/' . $user->photo) }}" alt="Current Photo" style="max-width: 200px; max-height: 200px;">
                                @else
                                    <img id="photoPreview" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; display: none;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function loadClasses() {
    const facultyId = document.getElementById('faculty_id').value;
    const classSelect = document.getElementById('class_id');

    if (facultyId) {
        fetch(`/api/classes?faculty_id=${facultyId}`)
            .then(response => response.json())
            .then(data => {
                classSelect.innerHTML = '<option value="">Chọn lớp</option>';
                data.forEach(cls => {
                    const selected = cls.id == '{{ $user->class_id }}' ? 'selected' : '';
                    classSelect.innerHTML += `<option value="${cls.id}" ${selected}>${cls.id}</option>`;
                });
            })
            .catch(error => {
                console.error('Error loading classes:', error);
                classSelect.innerHTML = '<option value="">Không thể tải lớp</option>';
            });
    } else {
        classSelect.innerHTML = '<option value="">Chọn lớp</option>';
    }
}

function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('photoPreview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

// Load classes on page load
document.addEventListener('DOMContentLoaded', function() {
    loadClasses();
});
</script>
@endsection
