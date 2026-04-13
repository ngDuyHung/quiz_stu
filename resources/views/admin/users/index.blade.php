@extends('admin.dashboard')

@section('title', 'Quản lý Sinh viên')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid mt-4">
    {{-- Bộ lọc --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control"
                           placeholder="Tìm MSSV, tên, email..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="faculty_id" class="form-select">
                        <option value="">-- Khoa --</option>
                        @foreach($faculties as $f)
                            <option value="{{ $f->id }}" {{ request('faculty_id') == $f->id ? 'selected' : '' }}>
                                {{ $f->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="class_id" class="form-select">
                        <option value="">-- Lớp --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="group_id" class="form-select">
                        <option value="">-- Nhóm --</option>
                        @foreach($groups as $g)
                            <option value="{{ $g->id }}" {{ request('group_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">-- Trạng thái --</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Bị khoá</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    {{-- Danh sách --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-users me-2"></i>Danh sách Sinh viên</span>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-success me-3" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-file-import me-1"></i> Import CSV
                </button>
                <span class="badge bg-secondary">Tổng: {{ $users->total() }}</span>
            </div>
        </div>
        
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>MSSV</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Lớp</th>
                        <th>Khoa</th>
                        <th>Nhóm</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>{{ $u->student_code }}</td>
                            <td>{{ $u->first_name }} {{ $u->last_name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->class_id }}</td>
                            <td>{{ $u->faculty->name ?? 'N/A' }}</td>
                            <td>{{ $u->group->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm {{ $u->status ? 'btn-success' : 'btn-secondary' }} toggle-status" 
                                        data-id="{{ $u->id }}" 
                                        data-status="{{ $u->status }}">
                                    {{ $u->status ? 'Hoạt động' : 'Bị khoá' }}
                                </button>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">Không có sinh viên nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="card-footer d-flex justify-content-center">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>

    {{-- Báo cáo Import (Hiển thị ở dưới bảng) --}}
    @if(session('import_report'))
        <div class="card shadow-sm border-0 mt-4 border-start border-4 border-warning" id="import-report-section">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="fas fa-exclamation-triangle me-2"></i> BÁO CÁO KẾT QUẢ IMPORT CHI TIẾT
            </div>
            <div class="card-body bg-light">
                <div class="row g-3 mb-3 text-center">
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded shadow-sm border border-success">
                            <h4 class="text-success mb-0">{{ session('import_report.success') }}</h4>
                            <span class="text-muted small fw-bold text-uppercase">Dòng thành công</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded shadow-sm border border-danger">
                            <h4 class="text-danger mb-0">{{ session('import_report.failed') }}</h4>
                            <span class="text-muted small fw-bold text-uppercase">Dòng gặp lỗi</span>
                        </div>
                    </div>
                </div>

                @if(session('import_report.errors')->isNotEmpty())
                    <div class="table-responsive bg-white rounded border shadow-sm mt-3">
                        <table class="table table-sm table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center" width="80">Dòng #</th>
                                    <th width="150">Cột/Trường lỗi</th>
                                    <th>Nội dung lỗi chi tiết từ hệ thống</th>
                                    <th>Dữ liệu đầu vào</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(session('import_report.errors') as $failure)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">{{ $failure->row() }}</td>
                                        <td><span class="badge bg-danger text-uppercase">{{ $failure->attribute() }}</span></td>
                                        <td class="text-danger small">{{ implode(' | ', $failure->errors()) }}</td>
                                        <td class="text-muted" style="font-size: 0.75rem;">
                                            @php 
                                                $rowData = array_filter($failure->values(), fn($value) => !is_null($value) && $value !== '');
                                            @endphp
                                            <code>{{ json_encode($rowData, JSON_UNESCAPED_UNICODE) }}</code>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-secondary mt-3 mb-0 py-2 small">
                        <i class="fas fa-info-circle me-1"></i> <strong>Lưu ý:</strong> Những dòng lỗi trên đã bị hệ thống tự động bỏ qua. Vui lòng kiểm tra lại file CSV và import lại các dòng này.
                    </div>
                @endif
            </div>
        </div>
        <script>
            // Tự động cuộn xuống phần báo cáo khi trang load lại
            window.onload = function() {
                document.getElementById('import-report-section').scrollIntoView({ behavior: 'smooth' });
            };
        </script>
    @endif
</div>

<script>
document.querySelectorAll('.toggle-status').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.closest('tr').querySelector('td:nth-child(2)').innerText;
        Swal.fire({
            title: 'Thay đổi trạng thái?',
            text: 'Sinh viên: ' + name,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (!result.isConfirmed) return;
            fetch(`/admin/users/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.dataset.status = data.status ? '1' : '0';
                this.className = 'btn btn-sm ' + (data.status ? 'btn-success' : 'btn-secondary') + ' toggle-status';
                this.innerText = data.status ? 'Hoạt động' : 'Bị khoá';
                showFlashAlert('success', 'Đã cập nhật trạng thái thành công!');
            });
        });
    });
});

function showFlashAlert(type, message) {
    var container = document.getElementById('flash-alert-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'flash-alert-container';
        container.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;min-width:320px;max-width:460px;';
        document.body.appendChild(container);
    }
    var icons = { success: 'fa-check-circle', danger: 'fa-times-circle', warning: 'fa-exclamation-triangle', info: 'fa-info-circle' };
    var labels = { success: 'Thành công!', danger: 'Thất bại!', warning: 'Cảnh báo!', info: 'Thông báo!' };
    var div = document.createElement('div');
    div.className = 'alert alert-' + type + ' alert-dismissible fade show shadow-sm';
    div.role = 'alert';
    div.innerHTML = '<i class="fas ' + (icons[type] || 'fa-info-circle') + ' me-2"></i><strong>' + (labels[type] || '') + '</strong> ' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    container.appendChild(div);
    setTimeout(function () { bootstrap.Alert.getOrCreateInstance(div).close(); }, 4000);
}
</script>

@include('partials.import_modal')
@endsection