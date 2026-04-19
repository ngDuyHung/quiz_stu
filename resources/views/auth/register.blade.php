<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }

        .register-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .register-header .logo {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .register-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .register-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .register-body {
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

        .btn-register {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
        }

        .login-link a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
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
            .register-card {
                margin: 10px;
            }

            .register-header {
                padding: 20px;
            }

            .register-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2>QUIZ - STU</h2>
                <p>Tạo tài khoản để bắt đầu hành trình học tập của bạn</p>
            </div>

            <div class="register-body">
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

                <form action="{{ route('auth.register') }}" method="POST">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col">
                            <label for="first_name" class="form-label">
                                <i class="fas fa-user me-2"></i>Họ
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                       value="{{ old('first_name') }}" placeholder="Nguyễn" required>
                                <span class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col">
                            <label for="last_name" class="form-label">
                                <i class="fas fa-user me-2"></i>Tên
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       value="{{ old('last_name') }}" placeholder="Văn A" required>
                                <span class="input-group-text">
                                    <i class="fas fa-signature"></i>
                                </span>
                            </div>
                        </div>
                    </div>

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

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Mật khẩu
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Ít nhất 6 ký tự" required>
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                   placeholder="Nhập lại mật khẩu" required>
                            <span class="input-group-text">
                                <i class="fas fa-check-circle"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-register">
                        <i class="fas fa-user-plus me-2"></i>Tạo tài khoản
                    </button>
                </form>

                <div class="login-link">
                    <span class="text-muted">Đã có tài khoản? </span>
                    <a href="{{ route('auth.login') }}">
                        <i class=""></i>Đăng nhập ngay
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.querySelector('form');
            const firstNameInput = document.getElementById('first_name');
            const lastNameInput = document.getElementById('last_name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const submitBtn = document.querySelector('.btn-register');

            // Validation messages
            const validationMessages = {
                firstName: {
                    required: 'Vui lòng nhập họ',
                    minLength: 'Họ phải có ít nhất 2 ký tự',
                    invalid: 'Họ chỉ được chứa chữ cái và khoảng trắng'
                },
                lastName: {
                    required: 'Vui lòng nhập tên',
                    minLength: 'Tên phải có ít nhất 2 ký tự',
                    invalid: 'Tên chỉ được chứa chữ cái và khoảng trắng'
                },
                email: {
                    required: 'Vui lòng nhập địa chỉ email',
                    invalid: 'Địa chỉ email không hợp lệ'
                },
                password: {
                    required: 'Vui lòng nhập mật khẩu',
                    minLength: 'Mật khẩu phải có ít nhất 6 ký tự',
                    pattern: 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường và 1 số'
                },
                passwordConfirmation: {
                    required: 'Vui lòng xác nhận mật khẩu',
                    mismatch: 'Mật khẩu xác nhận không khớp'
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

            // Validate name (first name or last name)
            function validateName(input, fieldName) {
                const name = input.value.trim();
                const nameRegex = /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/;

                if (!name) {
                    showError(input, validationMessages[fieldName].required);
                    return false;
                }

                if (name.length < 2) {
                    showError(input, validationMessages[fieldName].minLength);
                    return false;
                }

                if (!nameRegex.test(name)) {
                    showError(input, validationMessages[fieldName].invalid);
                    return false;
                }

                removeError(input);
                return true;
            }

            // Validate first name
            function validateFirstName() {
                return validateName(firstNameInput, 'firstName');
            }

            // Validate last name
            function validateLastName() {
                return validateName(lastNameInput, 'lastName');
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
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;

                if (!password) {
                    showError(passwordInput, validationMessages.password.required);
                    return false;
                }

                if (password.length < 6) {
                    showError(passwordInput, validationMessages.password.minLength);
                    return false;
                }

                if (!passwordRegex.test(password)) {
                    showError(passwordInput, validationMessages.password.pattern);
                    return false;
                }

                removeError(passwordInput);
                return true;
            }

            // Validate password confirmation
            function validatePasswordConfirmation() {
                const password = passwordInput.value;
                const confirmation = passwordConfirmationInput.value;

                if (!confirmation) {
                    showError(passwordConfirmationInput, validationMessages.passwordConfirmation.required);
                    return false;
                }

                if (password !== confirmation) {
                    showError(passwordConfirmationInput, validationMessages.passwordConfirmation.mismatch);
                    return false;
                }

                removeError(passwordConfirmationInput);
                return true;
            }

            // Validate form
            function validateForm() {
                const isFirstNameValid = validateFirstName();
                const isLastNameValid = validateLastName();
                const isEmailValid = validateEmail();
                const isPasswordValid = validatePassword();
                const isPasswordConfirmationValid = validatePasswordConfirmation();

                return isFirstNameValid && isLastNameValid && isEmailValid && isPasswordValid && isPasswordConfirmationValid;
            }

            // Real-time validation
            firstNameInput.addEventListener('blur', validateFirstName);
            firstNameInput.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateFirstName();
                }
            });

            lastNameInput.addEventListener('blur', validateLastName);
            lastNameInput.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateLastName();
                }
            });

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
                // Also validate confirmation if it has value
                if (passwordConfirmationInput.value) {
                    validatePasswordConfirmation();
                }
            });

            passwordConfirmationInput.addEventListener('blur', validatePasswordConfirmation);
            passwordConfirmationInput.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validatePasswordConfirmation();
                }
            });

            // Form submission
            registerForm.addEventListener('submit', function(e) {
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
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang tạo tài khoản...';
            });

            // Clear validation on input
            [firstNameInput, lastNameInput, emailInput, passwordInput, passwordConfirmationInput].forEach(input => {
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
