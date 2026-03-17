<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống trắc nghiệm - Sinh viên</title>
    <style>
        /* CORE STYLE */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f0f2f5; color: #1c1e21; line-height: 1.6; }

        /* NAVIGATION */
        nav { background: #ffffff; padding: 0 20px; height: 60px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        .logo { font-weight: bold; color: #1877f2; font-size: 1.2rem; text-decoration: none; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { text-decoration: none; color: #4b4f56; font-size: 0.95rem; font-weight: 500; }
        .nav-links a:hover { color: #1877f2; }
        
        .user-section { display: flex; align-items: center; gap: 15px; }
        .logout-btn { background: #f2f3f5; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: 600; color: #4b4f56; }
        .logout-btn:hover { background: #ebedf0; }

        /* MAIN LAYOUT */
        .container { max-width: 1000px; margin: 30px auto; padding: 0 15px; }
        
        /* WELCOME CARD */ 
        .welcome-banner { background: white; padding: 10px; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); margin-bottom: 20px; border-left: 5px solid #1877f2; }
        .welcome-banner h2 { color: #1877f2; margin-bottom: 10px; }
        .info-pill { display: inline-block; background: #e7f3ff; color: #1877f2; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-top: 10px; }

        /* FEATURE GRID */
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .card { background: white; border-radius: 12px; padding: 25px; text-align: center; box-shadow: 0 1px 2px rgba(0,0,0,0.1); transition: transform 0.2s; cursor: pointer; text-decoration: none; color: inherit; display: block; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .icon { font-size: 2.5rem; margin-bottom: 15px; display: block; }
        .card h3 { margin-bottom: 10px; color: #1c1e21; }
        .card p { color: #606770; font-size: 0.9rem; }

        /* RECENT ACTIVITY (Dành cho logic sau này) */
        .section-title { margin: 30px 0 15px; font-size: 1.1rem; font-weight: 700; color: #4b4f56; }
        .list-item { background: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <nav>
        <a href="#" class="logo">📚 STU QUIZ</a>
        <div class="nav-links">
            <a href="#">Trang chủ</a>
            <a href="#">Kỳ thi của tôi</a>
            <a href="#">Kết quả</a>
            <div class="user-section">
                <span style="font-size: 0.9rem;">Chào, <strong>{{ Auth::user()->first_name }}</strong></span>
                <form action="{{ route('auth.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">Đăng xuất</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-banner">
            <h2>Chào mừng bạn trở lại!</h2>
            <p>Email: <strong>{{ Auth::user()->email }}</strong></p>
            <span class="info-pill">Hệ: {{ Auth::user()->degree_type ?? 'Đại học' }}</span>
            <span class="info-pill">Lớp: {{ Auth::user()->class_id ?? 'Chưa cập nhật' }}</span>
        </div>

        <div class="section-title">Lối tắt chính</div>
        <div class="grid">
            <a href="#" class="card">
                <span class="icon">✍️</span>
                <h3>Vào thi</h3>
                <p>Danh sách các bài thi đang mở và bài thi sắp tới của bạn.</p>
            </a>

            <a href="#" class="card">
                <span class="icon">📊</span>
                <h3>Lịch sử thi</h3>
                <p>Xem lại điểm số, đáp án và chi tiết các bài thi đã nộp.</p>
            </a>

            <a href="#" class="card">
                <span class="icon">🔔</span>
                <h3>Thông báo</h3>
                <p>Cập nhật những tin tức và lịch thi mới nhất từ nhà trường.</p>
            </a>
        </div>

        <div class="section-title">Thông báo mới nhất</div>
        <div class="list-item">
            <div>
                <strong>Lịch thi giữa kỳ học kỳ 2</strong><br>
                <small style="color: #90949c;">Đăng bởi Admin • 2 giờ trước</small>
            </div>
            <a href="#" style="color: #1877f2; text-decoration: none; font-size: 0.9rem; font-weight: 600;">Xem chi tiết</a>
        </div>
    </div>

</body>
</html>