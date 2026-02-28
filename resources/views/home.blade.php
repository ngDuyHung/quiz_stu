<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon | Hệ thống Thi Trắc Nghiệm CTSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #1e293b;
            --accent-blue: #3b82f6;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            background: #0f172a;
            /* Nền tối sâu chuyên nghiệp */
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            overflow: hidden;
            /* Chống cuộn tuyệt đối trên Desktop */
        }

        .wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .main-card {
            background: #ffffff;
            border-radius: 30px;
            width: 100%;
            max-width: 950px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        /* Hiệu ứng thanh load chạy chậm ở trên cùng card */
        .top-loader {
            position: absolute;
            top: 0;
            left: 0;
            height: 4px;
            background: var(--accent-blue);
            animation: loading-bar 3s infinite ease-in-out;
        }

        @keyframes loading-bar {
            0% {
                width: 0;
                left: 0;
            }

            50% {
                width: 70%;
                left: 15%;
            }

            100% {
                width: 0;
                left: 100%;
            }
        }

        .tech-badge {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        .tech-badge:hover {
            border-color: var(--accent-blue);
            color: var(--accent-blue);
        }

        .team-box {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 12px;
            transition: transform 0.2s;
        }

        .team-box:hover {
            transform: translateY(-3px);
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .pulse-icon {
            animation: pulse 2s infinite;
            color: #10b981;
            /* Màu xanh lá thành công */
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Đảm bảo responsive cho mobile vẫn đẹp */
        @media (max-width: 576px) {

            body,
            html {
                overflow-y: auto;
            }

            .wrapper {
                align-items: flex-start;
                padding-top: 40px;
            }

            .main-card {
                padding: 30px 20px !important;
            }
        }


        .leader-box {
            position: relative;
            border: 1px solid #3b82f6 !important;
            /* Làm nổi bật khung của Leader */
        }

        .leader-label {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: #3b82f6;
            color: white;
            font-size: 9px;
            font-weight: 800;
            padding: 1px 8px;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="main-card p-4 p-md-5">
            <div class="top-loader"></div>

            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill bg-light border">
                    <i class="bi bi-circle-fill pulse-icon me-2" style="font-size: 8px;"></i>
                    <span class="small fw-bold text-uppercase tracking-wider">Hệ thống đang được triển khai</span>
                </div>
                <h1 class="display-6 fw-bold text-dark mb-2">CTSV-QUIZ <span class="text-primary">V12</span></h1>
                <p class="text-muted mx-auto" style="max-width: 500px;">Hệ thống thi trắc nghiệm trực tuyến thế hệ mới dành riêng cho Phòng Công tác Sinh viên.</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-12 col-md-6 border-end border-light">
                    <h6 class="fw-bold text-uppercase small text-secondary mb-3">Nền tảng phát triển</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="tech-badge">Laravel 12</span>
                        <span class="tech-badge">MySQL 8.0</span>
                        <span class="tech-badge">Bootstrap 5.3</span>
                    </div>
                </div>
                <div class="col-12 col-md-6 ps-md-4">
                    <h6 class="fw-bold text-uppercase small text-secondary mb-3">Khả năng vận hành</h6>
                    <div class="d-flex align-items-center">
                        <div class="h3 fw-bold text-primary mb-0 me-2">300+</div>
                        <div class="small text-muted border-start ps-2">Sinh viên truy cập<br>đồng thời cùng lúc</div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-top">
                <h6 class="fw-bold text-center text-uppercase small text-secondary mb-4">Đội ngũ thực hiện dự án</h6>
                <div class="row g-3">
                    <div class="col-12 col-sm-3">
                        <div class="team-box text-center ">
                        <!-- <div class="team-box text-center leader-box"> -->
                            <!-- <span class="leader-label">Leader</span> -->

                            <div class="fw-bold text-dark small">Nguyễn Duy Hùng</div>
                            <div class="text-secondary" style="font-size: 0.7rem; font-weight: 700;">LEADER / BACKEND</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="team-box text-center">
                            <div class="fw-bold text-dark small">Lương Tuệ Nhi</div>
                            <div class="text-secondary" style="font-size: 0.7rem; font-weight: 700;">FRONTEND UI</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="team-box text-center">
                            <div class="fw-bold text-dark small">Trần Khánh Duy</div>
                            <div class="text-secondary" style="font-size: 0.7rem; font-weight: 700;">BACKEND</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="team-box text-center">
                            <div class="fw-bold text-dark small">Nguyễn Hoàng Phúc</div>
                            <div class="text-secondary" style="font-size: 0.7rem; font-weight: 700;">BACKEND</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <div class="progress mb-2 mx-auto" style="height: 6px; max-width: 200px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 90%"></div>
                </div>
                <span class="text-secondary" style="font-size: 0.7rem; letter-spacing: 1px;">DỰ KIẾN HOÀN THÀNH: THÁNG 04/2026</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>