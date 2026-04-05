<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quiz System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS CORE LAYOUT */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; min-height: 100vh; background: #f0f2f5; color: #333; }

        /* SIDEBAR STYLE */
        aside { width: 260px; background: #2c3e50; color: #ecf0f1; display: flex; flex-direction: column; position: fixed; height: 100%; z-index: 1000; transition: all 0.3s; }
        aside h2 { padding: 20px; font-size: 1.1rem; text-align: center; background: #1a252f; color: #3498db; border-bottom: 1px solid #34495e; font-weight: bold; text-transform: uppercase; }
        
        aside nav { flex: 1; overflow-y: auto; padding: 10px 0; }
        .module-label { display: block; padding: 15px 20px 5px; font-size: 0.65rem; color: #95a5a6; text-transform: uppercase; font-weight: bold; letter-spacing: 1.2px; }
        
        aside nav a { display: block; color: #bdc3c7; padding: 12px 20px; text-decoration: none; font-size: 0.9rem; transition: all 0.2s; border-left: 4px solid transparent; }
        aside nav a i { margin-right: 10px; width: 20px; text-align: center; }
        aside nav a:hover { background: #34495e; color: #fff; border-left: 4px solid #3498db; }
        aside nav a.active { background: #34495e; color: #fff; border-left: 4px solid #3498db; font-weight: bold; }

        .logout-section { padding: 15px; background: #1a252f; }
        .btn-logout { width: 100%; padding: 10px; background: #e74c3c; border: none; color: white; cursor: pointer; border-radius: 6px; font-weight: bold; transition: 0.3s; }
        .btn-logout:hover { background: #c0392b; box-shadow: 0 2px 10px rgba(231, 76, 60, 0.4); }

        /* MAIN CONTENT STYLE */
        main { flex: 1; margin-left: 260px; display: flex; flex-direction: column; min-width: 0; }
        header { background: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 15px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 999; }
        
        .container-fluid-custom { padding: 25px; }
        
        /* Chỉnh lại Card cho chuyên nghiệp */
        .card-custom { background: white; padding: 25px; border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .breadcrumb-item.active { color: #3498db; font-weight: bold; }
        
        /* Fix Table cho Bootstrap */
        .table { background: white; border-radius: 8px; overflow: hidden; }
        .table thead { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <aside>
        <h2><i class="fas fa-graduation-cap"></i> QUIZ ADMIN</h2>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Trang chủ Dashboard
            </a>

            <span class="module-label">Module 1: Hệ thống</span>
            <a href="{{ route('admin.faculties.index') }}" class="{{ Request::is('admin/faculties*') ? 'active' : '' }}">
                <i class="fas fa-university"></i> Quản lý Khoa
            </a>
            <a href="#" class="{{ Request::is('admin/classes*') ? 'active' : '' }}">
                <i class="fas fa-school"></i> Quản lý Lớp học
            </a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Năm học & Học kỳ</a>

            <span class="module-label">Module 2: Nhân sự</span>
            <a href="#"><i class="fas fa-users"></i> Danh sách Sinh viên</a>
            <a href="{{ route('admin.user-groups.index') }}" class="{{ Request::is('admin/user-groups*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Nhóm người dùng
            </a>

            <span class="module-label">Module 3: Ngân hàng đề</span>
            <a href="{{ route('admin.question-categories.index') }}" class="{{ Request::is('admin/question-categories*') ? 'active' : '' }}">
    <i class="fas fa-folder-open"></i> Danh mục câu hỏi </a>
            <a href="#"><i class="fas fa-signal"></i> Mức độ khó</a>
            <a href="#"><i class="fas fa-question-circle"></i> Câu hỏi & Đáp án</a>

            <span class="module-label">Module 4: Kỳ thi</span>
            <a href="#"><i class="fas fa-file-alt"></i> Thiết lập bài thi</a>
            <a href="#"><i class="fas fa-clock"></i> Lịch trình thi</a>
        </nav>
        
        <div class="logout-section">
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
            </form>
        </div>
    </aside>

    <main>
        <header>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Phân khu</li>
                    <li class="breadcrumb-item active">@yield('title', 'Trang chủ')</li>
                </ol>
            </nav>
            <div class="user-info">
                <span class="text-muted mr-2 text-sm">Xin chào,</span> 
                <span class="badge bg-light text-dark shadow-sm py-2 px-3 border">
                    <i class="fas fa-user-circle text-primary"></i> <strong>{{ Auth::user()->first_name }}</strong>
                </span>
            </div>
        </header>

        <div class="container-fluid-custom">
            @if(Request::is('admin/dashboard'))
                <div class="card-custom border-start border-primary border-5">
                    <h3 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Hướng dẫn dành cho Team Code:</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Module 1:</strong> Phụ trách cấu trúc hạ tầng (Khoa/Lớp).</li>
                        <li class="list-group-item"><strong>Module 2:</strong> Phụ trách User và phân quyền.</li>
                        <li class="list-group-item"><strong>Module 3:</strong> Phụ trách CRUD câu hỏi (HTML content).</li>
                        <li class="list-group-item"><strong>Module 4:</strong> Phụ trách logic chấm điểm và tạo đề thi.</li>
                    </ul>
                </div>
            @else
                @yield('content') 
            @endif
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>