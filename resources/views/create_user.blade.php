<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng mới</title>
    
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
        .form-control {
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            border-color: #86b7fe;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            
            <div class="mb-4">
                <a href="/chude2" class="text-decoration-none text-secondary fw-medium">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
                </a>
            </div>

            <div class="card card-custom overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h4 class="fw-bold text-dark mb-0">Thêm người dùng mới</h4>
                    <p class="text-muted small">Điền thông tin bên dưới để tạo tài khoản mới</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-medium text-dark">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" name="name" required placeholder="Ví dụ: Nguyễn Văn A">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium text-dark">Địa chỉ Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control bg-light" name="email" required placeholder="name@example.com">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control bg-light border-start-0 ps-0" name="password" required placeholder="Nhập mật khẩu an toàn">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2 mt-4 border-top">
                            <button type="reset" class="btn btn-light px-4">Làm mới</button>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="bi bi-person-plus me-1"></i> Lưu người dùng
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>