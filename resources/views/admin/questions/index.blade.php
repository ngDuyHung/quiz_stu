@extends('admin.dashboard')

@section('title', 'Thống kê câu hỏi')

@section('content')

<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold">
            <i class="fas fa-chart-bar me-2"></i>Thống kê câu hỏi sai nhiều nhất
        </div>
        <div class="card-body">
            {{-- Bộ lọc --}}
            <form method="GET" class="row g-2 mb-4">
                <div class="col-md-4">
                    <select name="category_id" class="form-select">
                        <option value="">-- Danh mục --</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}"
                                {{ request('category_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="level_id" class="form-select">
                        <option value="">-- Mức độ --</option>
                        @foreach($levels as $l)
                            <option value="{{ $l->id }}"
                                {{ request('level_id') == $l->id ? 'selected' : '' }}>
                                {{ $l->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Lọc
                    </button>
                </div>
            </form>

            {{-- Bảng dữ liệu --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nội dung câu hỏi</th>
                            <th>Danh mục</th>
                            <th>Mức độ</th>
                            <th class="text-center">Lần xuất hiện</th>
                            <th class="text-center">% Đúng</th>
                            <th class="text-center">% Sai</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $q)
                        <tr>
                            <td>{{ $q->content }}</td>
                            <td><span class="badge bg-secondary">{{ $q->category }}</span></td>
                            <td><span class="badge bg-info text-dark">{{ $q->level }}</span></td>
                            <td class="text-center">{{ $q->times_served }}</td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ number_format($q->percent_correct, 2) }}%</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ number_format($q->percent_incorrect, 2) }}%</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.questions.edit', $q->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection