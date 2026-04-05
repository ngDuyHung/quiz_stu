@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row px-3">
    <div class="col-md-12">
        <h2 class="mb-4">📅 Quản lý Năm học & Học kỳ</h2>
    </div>

    <div class="col-md-4">
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><strong>Lỗi:</strong> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-bold py-3">
                <i class="fas fa-plus-circle me-2"></i>Thêm Năm Học
            </div>
            <div class="card-body">
                <form action="{{ route('admin.years.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Năm học</label>
                        <input type="text" name="year" class="form-control" placeholder="VD: 2025-2026" required pattern="\d{4}-\d{4}">
                        <small class="text-muted">Định dạng: XXXX-XXXX</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Học kỳ</label>
                        <select name="semester" class="form-select">
                            <option value="1">Học kỳ 1</option>
                            <option value="2">Học kỳ 2</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">Lưu Năm Học</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold py-3 d-flex justify-content-between">
                <span><i class="fas fa-list me-2"></i>Danh sách học kỳ</span>
                <span class="badge bg-secondary">{{ $years->count() }} bản ghi</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Năm học</th>
                            <th>Học kỳ</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($years as $y)
                        <tr class="{{ $y->is_active ? 'table-success' : '' }}">
                            <td class="ps-3"><strong>{{ $y->year }}</strong></td>
                            <td>Kỳ {{ $y->semester }}</td>
                            <td>
                                @if($y->is_active)
                                    <span class="badge bg-success shadow-sm">● Đang hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Chờ</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!$y->is_active)
                                    <form id="activate-form-{{ $y->id }}" action="{{ route('admin.years.activate', $y->id) }}" method="POST" class="d-none">@csrf</form>
                                    <button type="button" class="btn btn-sm btn-success shadow-sm" onclick="confirmActivate('{{ $y->id }}', '{{ $y->year }} - Kỳ {{ $y->semester }}')">
                                        Kích hoạt
                                    </button>

                                    <form id="delete-year-{{ $y->id }}" action="{{ route('admin.years.destroy', $y->id) }}" method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDeleteYear('{{ $y->id }}', '{{ $y->year }} - Kỳ {{ $y->semester }}')">
                                        Xóa
                                    </button>
                                @else
                                    <span class="text-muted small italic text-decoration-underline">Kỳ học mặc định</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Chưa có dữ liệu năm học.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmActivate(id, info) {
        Swal.fire({
            title: 'Kích hoạt học kỳ?',
            text: "Hệ thống sẽ chuyển sang vận hành theo " + info + ". Các kỳ khác sẽ bị tắt!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Đồng ý kích hoạt',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('activate-form-' + id).submit();
            }
        })
    }

    function confirmDeleteYear(id, info) {
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: "Dữ liệu " + info + " sẽ bị xóa vĩnh viễn!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-year-' + id).submit();
            }
        })
    }

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Thành công', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif

    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Thất bại', text: "{{ session('error') }}" });
    @endif
</script>
@endsection