<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 p-4">
                    <div class="card-body">
                        <h2 class="text-center mb-4 fw-bold">Đăng ký</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('auth.register') }}" method="POST">
                            @csrf
                            
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <label for="first_name" class="form-label small fw-bold text-secondary">Họ</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" 
                                           value="{{ old('first_name') }}" required>
                                </div>
                                <div class="col">
                                    <label for="last_name" class="form-label small fw-bold text-secondary">Tên</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" 
                                           value="{{ old('last_name') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-bold text-secondary">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email') }}" placeholder="example@gmail.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-bold text-secondary">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label small fw-bold text-secondary">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                Tạo tài khoản
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <span class="text-muted small">Đã có tài khoản?</span> 
                            <a href="{{ route('auth.login') }}" class="text-decoration-none small fw-bold">Đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>