@extends('admin.dashboard')

@section('title', 'Thêm Sinh viên mới')

@section('content')

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Thêm Sinh viên mới
                    </h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Lỗi:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Student Code --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mã sinh viên <span class="text-danger">*</span></label>
                                <input type="text" name="student_code" class="form-control @error('student_code') is-invalid @enderror"
                                       value="{{ old('student_code') }}" required>
                                @error('student_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- First Name --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Phone --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Birthdate --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" name="birthdate" class="form-control @error('birthdate') is-invalid @enderror"
                                       value="{{ old('birthdate') }}">
                                @error('birthdate')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Faculty --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Khoa <span class="text-danger">*</span></label>
                                <select name="faculty_id" id="faculty_id" class="form-select @error('faculty_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn Khoa --</option>
                                    @foreach($faculties as $f)
                                        <option value="{{ $f->id }}" data-faculty="{{ $f->id }}" {{ old('faculty_id') == $f->id ? 'selected' : '' }}>
                                            {{ $f->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('faculty_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Class --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lớp <span class="text-danger">*</span></label>
                                <select name="class_id" id="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn Lớp --</option>
                                    @foreach($classes as $c)
                                        <option value="{{ $c->id }}" data-faculty="{{ $c->faculty_id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Group --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nhóm</label>
                                <select name="group_id" class="form-select @error('group_id') is-invalid @enderror">
                                    <option value="">-- Chọn Nhóm --</option>
                                    @foreach($userGroups as $g)
                                        <option value="{{ $g->id }}" {{ old('group_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('group_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Academic Year --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Năm học</label>
                                <input type="text" name="academic_year" class="form-control @error('academic_year') is-invalid @enderror"
                                       placeholder="VD: 2023-2024" value="{{ old('academic_year') }}">
                                @error('academic_year')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Degree Type --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Loại bằng</label>
                                <input type="text" name="degree_type" class="form-control @error('degree_type') is-invalid @enderror"
                                       value="{{ old('degree_type') }}">
                                @error('degree_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Photo --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ảnh đại diện</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror"
                                       accept="image/*">
                                <small class="text-muted d-block mt-1">Định dạng: JPG, PNG (Tối đa 2MB)</small>
                                @error('photo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Bị khoá</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Thêm mới
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const facultySelect = document.getElementById('faculty_id');
    const classSelect = document.getElementById('class_id');

    // Filter classes by selected faculty
    facultySelect.addEventListener('change', function() {
        const selectedFaculty = this.value;
        const options = classSelect.querySelectorAll('option');
        
        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else {
                const facultyId = option.getAttribute('data-faculty');
                option.style.display = (facultyId === selectedFaculty) ? 'block' : 'none';
            }
        });
        
        // Reset class selection if not matching
        const selectedValue = classSelect.value;
        const selectedOption = classSelect.querySelector(`option[value="${selectedValue}"]`);
        if (selectedOption && selectedOption.style.display === 'none') {
            classSelect.value = '';
        }
    });

    // Load classes via AJAX when faculty changes
    facultySelect.addEventListener('change', function() {
        const facultyId = this.value;
        if (!facultyId) return;

        fetch(`/api/classes?faculty_id=${facultyId}`)
            .then(res => res.json())
            .then(classes => {
                classSelect.innerHTML = '<option value="">-- Chọn Lớp --</option>';
                classes.forEach(cls => {
                    const option = document.createElement('option');
                    option.value = cls.id;
                    option.textContent = cls.name;
                    option.setAttribute('data-faculty', cls.faculty_id);
                    classSelect.appendChild(option);
                });
            });
    });
});
</script>

@endsection
