@extends('admin.dashboard')

@section('title', 'Quản lý Khoa')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-plus-circle me-2"></i>Thêm Khoa Mới
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.faculties.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mã Khoa</label>
                            <input type="text" name="id"
                                   class="form-control @error('id') is-invalid @enderror"
                                   placeholder="VD: CNTT" required maxlength="10"
                                   value="{{ old('id') }}">
                            @error('id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Mã định danh duy nhất, tối đa 10 ký tự.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Khoa</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="VD: Công nghệ thông tin" required
                                   value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>Lưu Khoa
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-university me-2"></i>Danh sách các Khoa</span>
                    <span class="badge bg-secondary">Tổng: {{ $faculties->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã Khoa</th>
                                <th>Tên Khoa</th>
                                <th class="text-center">Số Lớp</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faculties as $faculty)
                            <tr>
                                <td class="fw-bold">{{ $faculty->id }}</td>
                                <td>{{ $faculty->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark">{{ $faculty->classes()->count() }}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $faculty->id }}">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-sm btn-danger"
                                            onclick="confirmDeleteFaculty('{{ $faculty->id }}', '{{ addslashes($faculty->name) }}')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                    <form id="delete-faculty-{{ $faculty->id }}"
                                          action="{{ route('admin.faculties.destroy', $faculty->id) }}"
                                          method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $faculty->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow border-0">
                                        <form action="{{ route('admin.faculties.update', $faculty->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title fw-bold">Cập nhật Khoa: {{ $faculty->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Mã Khoa (Không thể sửa)</label>
                                                    <input type="text" class="form-control bg-light" value="{{ $faculty->id }}" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tên Khoa</label>
                                                    <input type="text" name="name" class="form-control"
                                                           value="{{ $faculty->name }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">Chưa có khoa nào.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDeleteFaculty(id, name) {
    Swal.fire({
        title: 'Xác nhận xóa?',
        text: 'Khoa "' + name + '" sẽ bị xóa. Hệ thống sẽ chặn nếu Khoa đang có lớp học!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Đồng ý xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById('delete-faculty-' + id).submit();
    });
}

@if(session('success'))
    Swal.fire({ icon: 'success', title: 'Thành công', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
@endif
@if(session('error'))
    Swal.fire({ icon: 'error', title: 'Thất bại', text: "{{ session('error') }}" });
@endif
</script>
@endsection