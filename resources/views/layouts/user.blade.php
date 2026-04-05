<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard') - Axiom Academic</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@700;800&family=Inter:wght@300;400;600&display=swap" rel="stylesheet"/>

    <style>
        /* CORE LAYOUT (Đồng bộ hoàn toàn với Quiz Admin) */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Inter', sans-serif; 
            display: flex; 
            min-height: 100vh; 
            background: #f0f2f5; 
            color: #333; 
        }

        /* SIDEBAR STYLE (Đồng bộ màu #2c3e50) */
        aside { 
            width: 260px; 
            background: #2c3e50; 
            color: #ecf0f1; 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            height: 100%; 
            z-index: 1000; 
            transition: all 0.3s; 
        }
        aside .brand { 
            padding: 20px; 
            background: #1a252f; 
            border-bottom: 1px solid #34495e;
            text-align: center;
        }
        aside .brand h2 { 
            font-size: 1.1rem; 
            color: #3498db; 
            font-weight: bold; 
            text-transform: uppercase; 
            font-family: 'Manrope', sans-serif;
            margin: 0;
        }
        
        aside nav { flex: 1; overflow-y: auto; padding: 15px 0; }
        .nav-label { 
            display: block; 
            padding: 10px 20px 5px; 
            font-size: 0.65rem; 
            color: #95a5a6; 
            text-transform: uppercase; 
            font-weight: bold; 
            letter-spacing: 1.2px; 
        }
        
        aside nav a { 
            display: block; 
            color: #bdc3c7; 
            padding: 12px 20px; 
            text-decoration: none; 
            font-size: 0.9rem; 
            transition: all 0.2s; 
            border-left: 4px solid transparent; 
        }
        aside nav a i { margin-right: 12px; width: 20px; text-align: center; }
        aside nav a:hover, aside nav a.active { 
            background: #34495e; 
            color: #fff; 
            border-left: 4px solid #3498db; 
        }

        .user-status-card {
            margin: 15px;
            padding: 15px;
            background: rgba(52, 152, 219, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(52, 152, 219, 0.2);
        }

        /* MAIN CONTENT STYLE */
        main { flex: 1; margin-left: 260px; display: flex; flex-direction: column; min-width: 0; }
        header { 
            background: white; 
            padding: 12px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 15px rgba(0,0,0,0.05); 
            position: sticky; 
            top: 0; 
            z-index: 999; 
        }
        
        .content-wrapper { padding: 25px; flex-grow: 1; }
        
        /* CARD DESIGN (Consistent with Admin) */
        .card-custom { 
            background: white; 
            padding: 25px; 
            border-radius: 15px; 
            border: none; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.04); 
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .card-custom:hover { transform: translateY(-3px); }

        /* Progress Bar Custom */
        .progress { height: 8px; border-radius: 10px; background-color: #e9ecef; }
        .progress-bar { background-color: #3498db; border-radius: 10px; }

        /* Page Transition Effect */
        .page-fade { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
    @stack('css')
</head>
<body>

    <aside>
        <div class="brand">
            <h2><i class="fas fa-graduation-cap"></i> AXIOM STUDENT</h2>
        </div>
        <nav>
            <a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="#"><i class="fas fa-book-open"></i> Khóa học của tôi</a>
            <a href="#"><i class="fas fa-edit"></i> Kỳ thi sắp tới</a>
            <a href="#"><i class="fas fa-poll"></i> Kết quả học tập</a>
            
            <span class="nav-label">Hỗ trợ</span>
            <a href="#"><i class="fas fa-info-circle"></i> Trung tâm trợ giúp</a>
            <a href="#"><i class="fas fa-cog"></i> Cài đặt tài khoản</a>
        </nav>
        
        <div class="user-status-card text-center">
            <p class="small mb-1 text-info">GPA Hiện tại</p>
            <h4 class="fw-bold mb-0 text-white">3.92</h4>
        </div>

        <div class="p-3 border-top border-secondary">
            <button class="btn btn-outline-danger btn-sm w-100">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </button>
        </div>
    </aside>

    <main>
        <header>
            <div class="search-box d-none d-md-block">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Tìm kiếm học liệu...">
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="me-3 text-end d-none d-sm-block">
                    <p class="small fw-bold mb-0 text-dark">Julian Scholar</p>
                    <p class="text-muted mb-0" style="font-size: 0.7rem;">Học kỳ Thu 2024</p>
                </div>
                <div class="position-relative">
                    <img src="https://i.pravatar.cc/150?u=julian" class="rounded-circle border" width="40" height="40" alt="Avatar">
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle"></span>
                </div>
            </div>
        </header>

        <div class="content-wrapper page-fade">
            @yield('content')
        </div>

        <footer class="px-4 py-3 bg-white border-top text-center">
            <span class="small text-muted">© 2024 Axiom Academic. Global Status: <span class="text-success fw-bold">Online</span></span>
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>