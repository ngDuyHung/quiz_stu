@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-4">🏫 Quản lý Lớp học</h2>
            <form action="{{ route('admin.classes.index') }}" method="GET" class="d-flex align-items-center mb-4">
                <label class="me-2 fw-bold text-nowrap">Lọc theo Khoa:</label>
                <select name="faculty_id" class="form-select me-2" onchange="this.form.submit()">
                    <option value="">-- Tất cả Khoa --</option>
                    @foreach($faculties as $fac)
                        <option value="{{ $fac->id }}" {{ request('faculty_id') == $fac->id ? 'selected' : '' }}>
                            {{ $fac->name }}
                        </option>
                    @endforeach
                </select>
                @if(request('faculty_id'))
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </form>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white fw-bold">Thêm Lớp Mới</div>
                <div class="card-body">
                    <form action="{{ route('admin.classes.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Khoa chủ quản</label>
                            <select name="faculty_id" class="form-select" required>
                                <option value="">-- Chọn Khoa --</option>
                                @foreach($faculties as $fac)
                                    <option value="{{ $fac->id }}">{{ $fac->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mã Lớp (ID)</label>
                            <input type="text" name="id" class="form-control" placeholder="VD: D22_TH01" required maxlength="20">
                            <small class="text-muted">Mã định danh duy nhất.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Lớp</label>
                            <input type="text" name="name" class="form-control" placeholder="VD: ĐH Công nghệ thông tin 01" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Lưu Lớp Học</button>
                    </form>
                </div>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>Danh sách các lớp học</span>
                    <span class="badge bg-secondary">Tổng: {{ $classes->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã Lớp</th>
                                <th>Tên Lớp</th>
                                <th>Thuộc Khoa</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classes as $c)
                            <tr>
                                <td class="fw-bold">{{ $c->id }}</td>
                                <td>{{ $c->name }}</td>
                                <td><span class="badge bg-info text-dark">{{ $c->faculty->name ?? 'N/A' }}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ str_replace('.', '_', $c->id) }}">
                                        Sửa
                                    </button>

                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $c->id }}')">Xóa</button>
                                    
                                    <form id="delete-{{ $c->id }}" action="{{ route('admin.classes.destroy', $c->id) }}" method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ str_replace('.', '_', $c->id) }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow border-0">
                                        <form action="{{ route('admin.classes.update', $c->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title fw-bold">Cập nhật Lớp: {{ $c->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Mã Lớp (Không thể sửa)</label>
                                                    <input type="text" class="form-control bg-light" value="{{ $c->id }}" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tên Lớp</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $c->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Chuyển sang Khoa khác</label>
                                                    <select name="faculty_id" class="form-select" required>
                                                        @foreach($faculties as $fac)
                                                            <option value="{{ $fac->id }}" {{ $c->faculty_id == $fac->id ? 'selected' : '' }}>
                                                                {{ $fac->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                            <tr><td colspan="4" class="text-center py-4 text-muted">Không tìm thấy lớp học nào.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: "Nếu lớp có sinh viên, hệ thống sẽ chặn hành động này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-' + id).submit();
        })
    }

    // Xử lý Toast Message từ Controller (Acceptance Criteria 5)
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Thành công', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif

    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Thất bại', text: "{{ session('error') }}" });
    @endif
</script>
@endsection