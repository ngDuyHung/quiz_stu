@extends('admin.dashboard')

@section('title', 'Quản lý Sinh viên')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid mt-4">
    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Bộ lọc --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.students.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Tìm kiếm</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="MSSV, tên, email..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Khoa</label>
                    <select name="faculty_id" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        @foreach($faculties as $f)
                            <option value="{{ $f->id }}" {{ request('faculty_id') == $f->id ? 'selected' : '' }}>
                                {{ $f->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Lớp</label>
                    <select name="class_id" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Nhóm</label>
                    <select name="group_id" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        @foreach($userGroups as $g)
                            <option value="{{ $g->id }}" {{ request('group_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Trạng thái</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Bị khoá</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm w-100">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Danh sách --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-graduation-cap me-2"></i>Danh sách Sinh viên
                <span class="badge bg-light text-dark">Tổng: {{ $students->total() }}</span>
            </span>
            <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('admin.students.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Thêm mới
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
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
                        @forelse($students as $student)
                        <tr>
                            <td class="fw-bold text-primary">{{ $student->student_code }}</td>
                            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td class="text-muted small">{{ $student->email }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $student->schoolClass->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $student->faculty->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $student->userGroup->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm toggle-status {{ $student->status ? 'btn-success' : 'btn-secondary' }}"
                                        data-id="{{ $student->id }}"
                                        data-status="{{ $student->status }}"
                                        type="button">
                                    <i class="fas {{ $student->status ? 'fa-check' : 'fa-ban' }} me-1"></i>
                                    {{ $student->status ? 'Hoạt động' : 'Bị khoá' }}
                                </button>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.students.show', $student->id) }}" 
                                       class="btn btn-info" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.students.edit', $student->id) }}" 
                                       class="btn btn-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-delete" 
                                            data-id="{{ $student->id }}" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-reset-password" 
                                            data-id="{{ $student->id }}" title="Reset mật khẩu">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-info-circle me-2"></i>Không có sinh viên nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($students->hasPages())
        <div class="card-footer d-flex justify-content-center">
            {{ $students->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<script>
// Toggle Status
document.querySelectorAll('.toggle-status').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const row = this.closest('tr');
        const name = row.querySelector('td:nth-child(2)').innerText;
        
        Swal.fire({
            title: 'Thay đổi trạng thái?',
            text: 'Sinh viên: ' + name,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (!result.isConfirmed) return;
            
            fetch(`/admin/students/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const newStatus = data.status ? '1' : '0';
                this.dataset.status = newStatus;
                this.className = 'btn btn-sm toggle-status ' + (data.status ? 'btn-success' : 'btn-secondary');
                this.innerHTML = '<i class="fas ' + (data.status ? 'fa-check' : 'fa-ban') + ' me-1"></i>' + (data.status ? 'Hoạt động' : 'Bị khoá');
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Đã cập nhật', 
                    timer: 1500, 
                    showConfirmButton: false 
                });
            })
            .catch(err => {
                Swal.fire('Lỗi!', 'Không thể cập nhật trạng thái', 'error');
            });
        });
    });
});

// Delete Student
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const row = this.closest('tr');
        const name = row.querySelector('td:nth-child(2)').innerText;
        
        Swal.fire({
            title: 'Xóa sinh viên?',
            text: 'Sinh viên: ' + name + '\nHành động này không thể hoàn tác!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            confirmButtonColor: '#d33',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (!result.isConfirmed) return;
            
            const deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = `/admin/students/${id}`;
            deleteForm.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(deleteForm);
            deleteForm.submit();
        });
    });
});

// Reset Password
document.querySelectorAll('.btn-reset-password').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const row = this.closest('tr');
        const name = row.querySelector('td:nth-child(2)').innerText;
        const studentCode = row.querySelector('td:nth-child(1)').innerText;
        
        Swal.fire({
            title: 'Reset mật khẩu?',
            text: 'Sinh viên: ' + name + '\nMật khẩu sẽ được đặt thành: ' + studentCode + ' hoặc 12345678',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Reset',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (!result.isConfirmed) return;
            
            fetch(`/admin/students/${id}/reset-password`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Đã reset mật khẩu', 
                    text: data.message,
                    timer: 3000, 
                    showConfirmButton: false 
                });
            })
            .catch(err => {
                Swal.fire('Lỗi!', 'Không thể reset mật khẩu', 'error');
            });
        });
    });
});
</script>

@endsection
