@extends('admin.dashboard')

@section('title', 'Quản lý Bài thi')

@section('content')
<div class="container-fluid mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-file-alt me-2"></i>Danh sách Bài thi</span>
            <a href="{{ route('admin.quizzes.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus me-1"></i> Tạo mới
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tên bài thi</th>
                        <th>Thời gian</th>
                        <th class="text-center">Số phút</th>
                        <th class="text-center">Số lần tối đa</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $quiz)
                        <tr>
                            <td>
                                <strong>{{ $quiz->name }}</strong>
                                <br><small class="text-muted">{{ Str::limit($quiz->description, 50) }}</small>
                            </td>
                            <td>
                                <small>
                                    <i class="far fa-calendar-alt me-1"></i>Từ: {{ $quiz->start_date->format('H:i d/m/Y') }}<br>
                                    <i class="far fa-calendar-times me-1"></i>Đến: {{ $quiz->end_date->format('H:i d/m/Y') }}
                                </small>
                            </td>
                            <td class="text-center">{{ $quiz->duration_minutes }}'</td>
                            <td class="text-center">{{ $quiz->max_attempts }}</td>
                            <td class="text-center">{!! $quiz->status_badge !!}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa bài thi này?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">Chưa có bài thi nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($quizzes->hasPages())
            <div class="card-footer">
                {{ $quizzes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
