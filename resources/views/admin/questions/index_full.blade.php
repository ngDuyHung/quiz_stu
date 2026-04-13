@extends('admin.dashboard')

@section('title', 'Quản lý Câu hỏi & Đáp án')

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

    {{-- Error Message --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter Form --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.questions.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Tìm kiếm</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="Nội dung câu hỏi..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Danh mục</label>
                    <select name="category_id" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Mức độ</label>
                    <select name="level_id" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">Loại câu hỏi</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">-- Tất cả --</option>
                        @foreach($types as $key => $value)
                            <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary btn-sm w-100">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Questions List --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-question-circle me-2"></i>Danh sách Câu hỏi
                <span class="badge bg-light text-dark">Tổng: {{ $questions->total() }}</span>
            </span>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-2"></i>Thêm câu hỏi
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 35%">Nội dung</th>
                            <th style="width: 12%">Danh mục</th>
                            <th style="width: 8%">Mức độ</th>
                            <th style="width: 10%">Loại</th>
                            <th class="text-center" style="width: 10%">Đáp án</th>
                            <th class="text-center" style="width: 15%">Thống kê</th>
                            <th class="text-center" style="width: 10%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                        <tr>
                            <td>
                                <div class="text-truncate" style="max-width: 400px;" title="{{ strip_tags($question->content) }}">
                                    {!! substr(strip_tags($question->content), 0, 80) !!}...
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $question->category->name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning">{{ $question->level->name }}</span>
                            </td>
                            <td>
                                @if($question->type === 'single')
                                    <span class="badge bg-primary">Một đáp án</span>
                                @elseif($question->type === 'multiple')
                                    <span class="badge bg-success">Nhiều đáp án</span>
                                @else
                                    <span class="badge bg-secondary">Ghép cặp</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark">
                                    {{ $question->options->count() }} tùy chọn
                                </span>
                            </td>
                            <td class="text-center text-muted small">
                                <div>Phục vụ: {{ $question->times_served }}</div>
                                <div class="text-success">Đúng: {{ $question->times_correct }}</div>
                                <div class="text-danger">Sai: {{ $question->times_incorrect }}</div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.questions.show', $question->id) }}" 
                                       class="btn btn-info" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.questions.edit', $question->id) }}" 
                                       class="btn btn-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-delete" 
                                            data-id="{{ $question->id }}" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                Không có câu hỏi nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($questions->hasPages())
        <div class="card-footer d-flex justify-content-center">
            {{ $questions->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<script>
// Delete Question
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;

        Swal.fire({
            title: 'Xóa câu hỏi?',
            text: 'Hành động này sẽ xóa câu hỏi và tất cả đáp án của nó!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            confirmButtonColor: '#d33',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (!result.isConfirmed) return;

            const deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = `/admin/questions/${id}`;
            deleteForm.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(deleteForm);
            deleteForm.submit();
        });
    });
});
</script>

@endsection
