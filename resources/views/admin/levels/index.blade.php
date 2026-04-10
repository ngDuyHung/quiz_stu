@extends('admin.dashboard')

@section('title', 'Mức độ khó')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="card-custom">
    <h2 class="mb-4 text-primary"><i class="fas fa-layer-group"></i> Quản lý mức độ khó</h2>

    <div class="mb-4 p-3 bg-light rounded border border-primary">
        <form action="{{ route('admin.question-levels.store') }}" method="POST">
            @csrf
            <div class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="name" class="form-control" placeholder="Tên mức độ mới (VD: Dễ, Trung bình, Khó)..." required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">➕ Tạo mới</button>
                </div>
            </div>
        </form>
    </div>


    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white border">
            <thead class="table-dark">
                <tr>
                    <th width="10%">ID</th>
                    <th width="50%">Tên mức độ</th>
                    <th width="15%" class="text-center">Số câu hỏi</th>
                    <th width="25%" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($levels as $level)
                <tr>
                    <td>#{{ $level->id }}</td>
                    <td><strong>{{ $level->name }}</strong></td>
                    <td class="text-center">
                        <span class="badge bg-info rounded-pill">{{ $level->questions_count }}</span>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-warning me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal{{ $level->id }}">
                            <i class="fas fa-edit"></i> Sửa
                        </button>

                        <form id="delete-level-{{ $level->id }}" action="{{ route('admin.question-levels.destroy', $level->id) }}" method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                                onclick="confirmDeleteLevel('{{ $level->id }}', '{{ addslashes($level->name) }}', {{ $level->questions_count }})">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    </td>
                </tr>

                <div class="modal fade" id="editModal{{ $level->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.question-levels.update', $level->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-dark">Chỉnh sửa mức độ khó</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tên mức độ</label>
                                        <input type="text" name="name" class="form-control" value="{{ $level->name }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Chưa có mức độ khó nào. Hãy tạo mức độ đầu tiên!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDeleteLevel(id, name, count) {
    let warningText = 'Xóa mức độ <strong>"' + name + '"</strong>';
    
    if (count > 0) {
        warningText += '<br><br><span class="text-danger"><strong>⚠️ CẢNH BÁO:</strong> ' + count + ' câu hỏi đang sử dụng mức độ này sẽ được xóa khỏi mức độ (level_id sẽ được set NULL)!</span>';
    }
    
    Swal.fire({
        title: 'Xác nhận xóa!',
        html: warningText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Đồng ý xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById('delete-level-' + id).submit();
    });
}
</script>
@endsection
