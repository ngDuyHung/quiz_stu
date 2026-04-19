<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }

        .login-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .login-header .logo {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .login-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .btn-login {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
        }

        .register-link a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #224abe;
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            color: #6c757d;
        }

        .form-control:focus + .input-group-text,
        .input-group-text:focus {
            border-color: #4e73df;
        }

        .form-control.is-valid {
            border-color: #28a745;
        }

        .form-control.is-valid:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 576px) {
            .login-card {
                margin: 10px;
            }

            .login-header {
                padding: 20px;
            }

            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2>QUIZ - STU</h2>
                <p>Đăng nhập để tiếp tục hành trình học tập của bạn</p>
            </div>

            <div class="login-body">
                @if ($errors->any())
                    <div class="alert alert-danger py-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Có lỗi xảy ra:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ old('email') }}" placeholder="name@example.com" required>
                            <span class="input-group-text">
                                <i class="fas fa-at"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Mật khẩu
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                    </button>
                </form>

                <div class="divider">
                    <span>hoặc</span>
                </div>

                <div class="register-link">
                    <span class="text-muted">Chưa có tài khoản? </span>
                    <a href="{{ route('auth.register') }}">
                        <i class=""></i>Đăng ký ngay
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const submitBtn = document.querySelector('.btn-login');

            // Validation messages
            const validationMessages = {
                email: {
                    required: 'Vui lòng nhập địa chỉ email',
                    invalid: 'Địa chỉ email không hợp lệ'
                },
                password: {
                    required: 'Vui lòng nhập mật khẩu',
                    minLength: 'Mật khẩu phải có ít nhất 6 ký tự'
                }
            };

            // Create error message element
            function createErrorElement(message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i>${message}`;
                return errorDiv;
            }

            // Remove error message
            function removeError(input) {
                const errorElement = input.parentElement.querySelector('.invalid-feedback');
                if (errorElement) {
                    errorElement.remove();
                }
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }

            // Show error message
            function showError(input, message) {
                removeError(input);
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                const errorElement = createErrorElement(message);
                input.parentElement.appendChild(errorElement);
            }

            // Validate email
            function validateEmail() {
                const email = emailInput.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!email) {
                    showError(emailInput, validationMessages.email.required);
                    return false;
                }

                if (!emailRegex.test(email)) {
                    showError(emailInput, validationMessages.email.invalid);
                    return false;
                }

                removeError(emailInput);
                return true;
            }

            // Validate password
            function validatePassword() {
                const password = passwordInput.value;

                if (!password) {
                    showError(passwordInput, validationMessages.password.required);
                    return false;
                }

                if (password.length < 6) {
                    showError(passwordInput, validationMessages.password.minLength);
                    return false;
                }

                removeError(passwordInput);
                return true;
            }

            // Validate form
            function validateForm() {
                const isEmailValid = validateEmail();
                const isPasswordValid = validatePassword();

                return isEmailValid && isPasswordValid;
            }

            // Real-time validation
            emailInput.addEventListener('blur', validateEmail);
            emailInput.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateEmail();
                }
            });

            passwordInput.addEventListener('blur', validatePassword);
            passwordInput.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validatePassword();
                }
            });

            // Form submission
            loginForm.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    // Scroll to first error
                    const firstError = document.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                    return false;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang đăng nhập...';
            });

            // Clear validation on input
            [emailInput, passwordInput].forEach(input => {
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        removeError(this);
                    }
                });
            });
        });
    </script> -->
</body>
</html>
