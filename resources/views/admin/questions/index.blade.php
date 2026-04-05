<!DOCTYPE html>
<html>
<head>
    <title>Thống kê câu hỏi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2 class="mb-4">📊 Thống kê câu hỏi sai nhiều nhất</h2>

    {{-- FILTER --}}
    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <select name="category_id" class="form-control">
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
            <select name="level_id" class="form-control">
                <option value="">-- Mức độ --</option>
                @foreach($levels as $l)
                    <option value="{{ $l->id }}"
                        {{ request('level_id') == $l->id ? 'selected' : '' }}>
                        {{ $l->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <button class="btn btn-primary">Lọc</button>
        </div>
    </form>

    {{-- TABLE --}}
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nội dung</th>
                <th>Danh mục</th>
                <th>Mức độ</th>
                <th>Lần xuất hiện</th>
                <th>% đúng</th>
                <th>% sai</th>
                <th>Hành động</th>
            </tr>
        </thead>

        <tbody>
            @forelse($questions as $q)
            <tr>
                <td>{{ $q->content }}</td>
                <td>{{ $q->category }}</td>
                <td>{{ $q->level }}</td>
                <td>{{ $q->times_served }}</td>
                <td class="text-success">
                    {{ number_format($q->percent_correct, 2) }}%
                </td>
                <td class="text-danger">
                    {{ number_format($q->percent_incorrect, 2) }}%
                </td>
                <td>
                    <a href="{{ route('admin.questions.edit', $q->id) }}"
                       class="btn btn-sm btn-warning">
                        Sửa
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">
                    Không có dữ liệu
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
<a href="{{ route('admin.users.resetPassword', $u->id) }}" 
   class="btn btn-sm btn-danger">
   Reset mật khẩu
</a>
</body>
</html>