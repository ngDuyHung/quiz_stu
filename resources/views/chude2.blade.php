<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng - Chủ đề 2</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6; 
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .table-custom th {
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .table-custom tbody tr {
            transition: all 0.2s ease;
        }
        .table-custom tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
        }
        .action-btn {
            border-radius: 8px;
            padding: 0.25rem 0.6rem;
        }
        .api-docs {
            border-left: 4px solid #0d6efd;
        }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="mb-4">
        <h2 class="fw-bold mb-1 text-dark">Chủ đề 2</h2>
        <p class="text-muted mb-0">Quản lý danh sách người dùng hệ thống</p>
    </div>

    <div class="alert alert-primary bg-white shadow-sm api-docs mb-4" role="alert">
        <h5 class="alert-heading fw-bold fs-8 text-primary mb-2">
            <i class="bi bi-server me-2"></i>Thông tin API Endpoints dành cho Frontend/Mobile:
        </h5>
        <ul class="mb-0 small text-secondary">
            <li><strong class="text-dark">Lấy danh sách tất cả Users (GET):</strong> <code>/api/users</code></li>
            <li><strong class="text-dark">Lấy chi tiết 1 User (GET):</strong> <code>/api/users/{id}</code> (Ví dụ: <code>/api/users/1</code>)</li>
            <!-- <li><strong class="text-dark">Thêm User mới (POST):</strong> <code>/api/users</code></li>
            <li><strong class="text-dark">Cập nhật User (PUT):</strong> <code>/api/users/{id}</code></li>
            <li><strong class="text-dark">Xóa User (DELETE):</strong> <code>/api/users/{id}</code></li> -->
        </ul>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        
        <form action="/" method="GET" class="d-flex flex-grow-1" style="max-width: 400px;">
            <div class="input-group shadow-sm rounded-pill overflow-hidden">
                <input type="text" name="search" class="form-control border-0 bg-white ps-4" 
                       placeholder="Tìm theo tên hoặc email..." 
                       value="{{ request('search') }}">
                
                <button class="btn btn-white bg-white border-0 text-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                
                @if(request('search'))
                    <a href="/" class="btn btn-white bg-white border-0 text-danger" title="Xóa bộ lọc">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                @endif
            </div>
        </form>

        <a href="{{ route('user.create') }}" class="btn btn-primary px-4 py-2 fw-medium shadow-sm rounded-pill">
            <i class="bi bi-person-plus-fill me-2"></i>Thêm người dùng
        </a>
    </div>

    <div class="card card-custom overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th class="py-3">Họ và tên</th>
                            <th class="py-3">Email</th>
                            <th class="text-end pe-4 py-3">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle rounded-pill px-3">
                                    #{{ $user->id }}
                                </span>
                            </td>
                            <td class="fw-medium text-dark">{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td class="text-end pe-4">
                                <a href="/chude2/{{$user->id}}/edit" class="btn btn-sm btn-outline-info action-btn me-2" title="Chỉnh sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="/chude2/{{$user->id}}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng {{ $user->name }} không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger action-btn" title="Xóa">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                                <span class="text-muted">Không tìm thấy người dùng nào.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>