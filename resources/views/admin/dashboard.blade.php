<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Layout Team</title>
    <style>
        /* CSS RESET & CORE LAYOUT */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; display: flex; min-height: 100vh; background: #f4f7f6; color: #333; }

        /* SIDEBAR STYLE */
        aside { width: 260px; background: #2c3e50; color: #ecf0f1; display: flex; flex-direction: column; position: fixed; height: 100%; box-shadow: 2px 0 5px rgba(0,0,0,0.1); }
        aside h2 { padding: 25px; font-size: 1.2rem; text-align: center; background: #1a252f; color: #3498db; border-bottom: 1px solid #34495e; }
        
        aside nav { flex: 1; overflow-y: auto; padding: 10px 0; }
        
        /* CHÚ THÍCH PHÂN CHIA MODULE */
        .module-label { display: block; padding: 15px 20px 5px; font-size: 0.7rem; color: #7f8c8d; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; }
        
        aside nav a { display: block; color: #bdc3c7; padding: 12px 25px; text-decoration: none; font-size: 0.9rem; transition: all 0.2s; border-left: 4px solid transparent; }
        aside nav a:hover { background: #34495e; color: white; border-left: 4px solid #3498db; }
        aside nav a.active { background: #34495e; color: white; border-left: 4px solid #3498db; }

        .logout-section { padding: 15px; border-top: 1px solid #34495e; }
        .btn-logout { width: 100%; padding: 10px; background: #e74c3c; border: none; color: white; cursor: pointer; border-radius: 4px; font-weight: bold; }

        /* MAIN CONTENT STYLE */
        main { flex: 1; margin-left: 260px; }
        header { background: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .container { padding: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); line-height: 1.6; }
    </style>
</head>
<body>

    <aside>
        <h2>QUIZ ADMIN</h2>
        <nav>
            <a href="#" class="active">🏠 Trang chủ Dashboard</a>

            
            <span class="module-label">Module 1: Hệ thống</span>

            <a href="{{ route('admin.faculties.index') }}" 
            class="{{ request()->routeIs('admin.faculties.*') ? 'active' : '' }}">
            🏢 Quản lý Khoa
            </a>

            <a href="{{ route('admin.classes.index') }}"
            class="{{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
            🏫 Quản lý Lớp học
            </a>

            <a href="{{ route('admin.years.index') }}"
            class="{{ request()->routeIs('admin.years.*') ? 'active' : '' }}">
            📅 Năm học & Học kỳ
            </a>

            <!-- Moudle He Thong  -->

            <span class="module-label">Module 2: Nhân sự</span>
            <a href="#">👤 Danh sách Sinh viên</a>
            <a href="#">🛡️ Nhóm người dùng</a>

            <span class="module-label">Module 3: Ngân hàng đề</span>
            <a href="#">📂 Danh mục câu hỏi</a>
            <a href="#">📊 Mức độ khó</a>
            <a href="#">❓ Câu hỏi & Đáp án</a>

            <span class="module-label">Module 4: Kỳ thi</span>
            <a href="#">📝 Thiết lập bài thi</a>
            <a href="#">🕒 Lịch trình thi</a>
            <a href="#">📈 Kết quả & Điểm</a>
            <a href="#">💬 Phản hồi & Góp ý</a>

            <span class="module-label">Tiện ích</span>
            <a href="#">🔔 Thông báo</a>
        </nav>
        
        <div class="logout-section">
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Đăng xuất</button>
            </form>
        </div>
    </aside>

    <main>
        <header>
            <div>Phân khu: <strong style="color: #3498db;">Trang chủ</strong></div>
            <div>Xin chào, <strong>{{ Auth::user()->first_name }}</strong></div>
        </header>

        <div class="container">
            <div class="card">
                <h3>Hướng dẫn dành cho Team Code:</h3>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li><strong>Module 1:</strong> Phụ trách cấu trúc hạ tầng (Khoa/Lớp).</li>
                    <li><strong>Module 2:</strong> Phụ trách User và phân quyền.</li>
                    <li><strong>Module 3:</strong> Phụ trách CRUD câu hỏi (HTML content).</li>
                    <li><strong>Module 4:</strong> Phụ trách logic chấm điểm và tạo đề thi.</li>
                </ul>
            </div>
        </div>
    </main>

</body>
</html>