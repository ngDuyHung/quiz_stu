@extends('admin.dashboard')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">Tìm kiếm & Lọc câu hỏi</div>
        <div class="card-body">
            <form action="{{ route('admin.questions.index') }}" method="GET" class="row g-2 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">-- Danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="level_id" class="form-select">
                        <option value="">-- Mức độ --</option>
                        @foreach($levels as $lv)
                            <option value="{{ $lv->id }}" {{ request('level_id') == $lv->id ? 'selected' : '' }}>{{ $lv->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">-- Loại --</option>
                        <option value="single" {{ request('type') == 'single' ? 'selected' : '' }}>Single Choice</option>
                        <option value="multiple" {{ request('type') == 'multiple' ? 'selected' : '' }}>Multiple Choice</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </form>

            <table class="table table-hover border">
                <thead class="table-light">
                    <tr>
                        <th>Nội dung (Preview)</th>
                        <th>Danh mục</th>
                        <th>Mức độ</th>
                        <th>Loại</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questions as $q)
                    <tr>
                        <td>
                            <div title="{{ strip_tags($q->content) }}">{{ $q->preview }}</div>
                        </td>
                        <td>{{ $q->category->name ?? 'N/A' }}</td>
                        <td>{{ $q->level->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-secondary">{{ $q->type }}</span></td>
                        <td>
                            <a href="{{ route('admin.questions.edit', $q->id) }}" class="btn btn-sm btn-outline-warning">Sửa</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Không tìm thấy kết quả phù hợp.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $questions->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection