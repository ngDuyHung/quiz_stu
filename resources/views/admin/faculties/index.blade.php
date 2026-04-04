@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">🏢 Quản lý danh sách Khoa</h2>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white fw-bold">Thêm Khoa Mới</div>
                <div class="card-body">
                    <form action="{{ route('admin.faculties.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Mã Khoa (ID)</label>
                            <input type="text" name="id" class="form-control" placeholder="VD: cntt" required maxlength="10">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tên Khoa</label>
                            <input type="text" name="name" class="form-control" placeholder="VD: Công Nghệ Thông Tin" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">Lưu Khoa</button>
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
                    <span>Danh sách các khoa</span>
                    <span class="badge bg-secondary">Tổng: {{ $faculties->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã Khoa</th>
                                <th>Tên Khoa</th>
                                <th class="text-center">Số lớp</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faculties as $f)
                            <tr>
                                <td class="fw-bold text-primary">{{ strtoupper($f->id) }}</td>
                                <td>{{ $f->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark">{{ $f->classes_count }}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $f->id }}">Sửa</button>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ $f->id }}', '{{ $f->name }}')">Xóa</button>
                                    
                                    <form id="delete-form-{{ $f->id }}" action="{{ route('admin.faculties.destroy', $f->id) }}" method="POST" style="display: none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $f->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('admin.faculties.update', $f->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title fw-bold">Chỉnh sửa Khoa: {{ $f->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Mã Khoa (Cố định)</label>
                                                    <input type="text" class="form-control bg-light" value="{{ $f->id }}" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Tên Khoa mới</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $f->name }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-warning">Cập nhật ngay</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">Chưa có dữ liệu khoa nào.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: "Bạn muốn xóa khoa " + name + "? Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Đồng ý xóa!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    // Hiển thị thông báo Toast từ Session
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Thành công', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif

    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Lỗi hệ thống', text: "{{ session('error') }}", confirmButtonColor: '#d33' });
    @endif
</script>

@endsection