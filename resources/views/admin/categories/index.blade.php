@extends('admin.dashboard')

@section('title', 'Danh mục câu hỏi')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="card-custom">
    <h2 class="mb-4 text-primary"><i class="fas fa-folder-open"></i> Quản lý danh mục câu hỏi</h2>

    <div class="mb-4 p-3 bg-light rounded border border-primary">
        <form action="{{ route('admin.question-categories.store') }}" method="POST">
            @csrf
            <div class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="name" class="form-control" placeholder="Tên danh mục mới..." required>
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
                    <th width="50%">Tên danh mục</th>
                    <th width="15%" class="text-center">Số câu hỏi</th>
                    <th width="25%" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>#{{ $cat->id }}</td>
                    <td><strong>{{ $cat->name }}</strong></td>
                    <td class="text-center">
                        <span class="badge bg-secondary rounded-pill">{{ $cat->questions_count }}</span>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-warning me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal{{ $cat->id }}">
                            <i class="fas fa-edit"></i> Sửa
                        </button>

                        <form id="delete-cat-{{ $cat->id }}" action="{{ route('admin.question-categories.destroy', $cat->id) }}" method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                                onclick="confirmDeleteCat('{{ $cat->id }}', '{{ addslashes($cat->name) }}')">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    </td>
                </tr>

                <div class="modal fade" id="editModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.question-categories.update', $cat->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-dark">Chỉnh sửa danh mục</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tên danh mục</label>
                                        <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
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
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDeleteCat(id, name) {
    Swal.fire({
        title: 'CẢnh báo!',
        html: 'Xóa danh mục <strong>"' + name + '"</strong> sẽ xóa toàn bộ câu hỏi bên trong!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Đồng ý xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById('delete-cat-' + id).submit();
    });
}

</script>
@endsection