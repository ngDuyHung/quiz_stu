@extends('admin.dashboard')

@section('title', 'Chi tiết Sinh viên')

@section('content')

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Chi tiết Sinh viên
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Sửa
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteStudent()">
                            <i class="fas fa-trash me-1"></i>Xóa
                        </button>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            @if($student->photo)
                                <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" 
                                     style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; border: 3px solid #e0e0e0;">
                            @else
                                <div style="width: 200px; height: 200px; background: #e0e0e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-user" style="font-size: 80px; color: #999;"></i>
                                </div>
                            @endif
                            <div class="mt-3">
                                <span class="badge bg-{{ $student->status ? 'success' : 'danger' }}">
                                    {{ $student->status ? 'Hoạt động' : 'Bị khoá' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold" style="width: 30%;">Mã sinh viên:</td>
                                        <td class="text-primary fw-bold">{{ $student->student_code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Họ tên:</td>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Email:</td>
                                        <td><a href="mailto:{{ $student->email }}">{{ $student->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Số điện thoại:</td>
                                        <td>{{ $student->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Ngày sinh:</td>
                                        <td>{{ $student->birthdate?->format('d/m/Y') ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Khoa:</td>
                                        <td>
                                            <span class="badge bg-info">{{ $student->faculty->name ?? 'N/A' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Lớp:</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $student->schoolClass->name ?? 'N/A' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Nhóm:</td>
                                        <td>{{ $student->userGroup->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Năm học:</td>
                                        <td>{{ $student->academic_year ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Loại bằng:</td>
                                        <td>{{ $student->degree_type ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6 class="mb-3"><i class="fas fa-lock me-2"></i>Quản lý Mật khẩu</h6>
                            <button type="button" class="btn btn-primary btn-sm" onclick="resetPassword()">
                                <i class="fas fa-key me-1"></i>Reset mật khẩu
                            </button>
                            <small class="d-block mt-2 text-muted">Mật khẩu sẽ được đặt lại về: <strong>{{ $student->student_code }} hoặc 12345678</strong></small>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3"><i class="fas fa-toggle-on me-2"></i>Thay đổi Trạng thái</h6>
                            <button type="button" class="btn btn-{{ $student->status ? 'warning' : 'success' }} btn-sm" onclick="toggleStatus()">
                                <i class="fas {{ $student->status ? 'fa-ban' : 'fa-check' }} me-1"></i>
                                {{ $student->status ? 'Khoá tài khoản' : 'Kích hoạt tài khoản' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="deleteForm" action="{{ route('admin.students.destroy', $student->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleStatus() {
    Swal.fire({
        title: 'Thay đổi trạng thái?',
        text: 'Sinh viên: {{ $student->first_name }} {{ $student->last_name }}',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (!result.isConfirmed) return;
        
        fetch(`/admin/students/{{ $student->id }}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Đã cập nhật',
                text: data.message,
                timer: 2000
            }).then(() => {
                location.reload();
            });
        });
    });
}

function resetPassword() {
    Swal.fire({
        title: 'Reset mật khẩu?',
        text: 'Mật khẩu sẽ được đặt lại về mã sinh viên: {{ $student->student_code }}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Reset',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (!result.isConfirmed) return;
        
        fetch(`/admin/students/{{ $student->id }}/reset-password`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Đã reset mật khẩu',
                text: data.message,
                timer: 3000
            });
        });
    });
}

function deleteStudent() {
    Swal.fire({
        title: 'Xóa sinh viên?',
        text: 'Sinh viên: {{ $student->first_name }} {{ $student->last_name }}\nHành động này không thể hoàn tác!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        confirmButtonColor: '#d33',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (!result.isConfirmed) return;
        document.getElementById('deleteForm').submit();
    });
}
</script>

@endsection
