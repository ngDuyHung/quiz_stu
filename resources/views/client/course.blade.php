<!DOCTYPE html>
<html class="light" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Khóa học của tôi - Quiz STU</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#003466",
                        "secondary": "#1a6299",
                        "surface": "#f7f9fb",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#424750",
                        "outline": "#737781",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-lowest": "#ffffff",
                        "primary-fixed": "#d5e3ff",
                        "primary-container": "#1a4b84",
                        "error": "#ba1a1a",
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "mono": ["JetBrains Mono"],
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Manrope', sans-serif; }
        .page-fade { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>

<body class="bg-surface text-on-surface flex min-h-screen">
    @include('client.partials.sidebar')

    <main class="ml-64 flex-1 flex flex-col min-h-screen">
        <header class="h-16 flex justify-between items-center px-8 bg-white/80 backdrop-blur-xl border-b border-slate-200/50 sticky top-0 z-40">
            <h2 class="text-lg font-bold text-primary">Quản lý khóa học IT</h2>
            <div class="flex items-center gap-6">
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 transition-all relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
                </button>
                <div class="h-8 w-[1px] bg-slate-200"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-xs font-bold text-primary">ALEX NGUYEN</p>
                        <p class="text-[10px] text-slate-500 font-medium tracking-tight">MSSV: 20240001</p>
                    </div>
                    <img src="https://i.pravatar.cc/150?u=alex" alt="User" class="w-10 h-10 rounded-full object-cover border-2 border-primary/10" />
                </div>
            </div>
        </header>

        <div class="p-8 max-w-6xl w-full mx-auto page-fade">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">terminal</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Đang học</p>
                        <h3 class="text-2xl font-bold text-slate-800">3</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Hoàn thành</p>
                        <h3 class="text-2xl font-bold text-slate-800">12</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">code</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Git Commits</p>
                        <h3 class="text-2xl font-bold text-slate-800">450</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold">Tất cả</button>
                        <button class="px-4 py-2 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium">Đang học</button>
                        <button class="px-4 py-2 text-slate-600 hover:bg-slate-50 rounded-lg text-sm font-medium">Đã xong</button>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                        <input type="text" placeholder="Tìm tên môn hoặc ID..." class="pl-10 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/10 outline-none w-64">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Chi tiết khóa học</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Giảng viên</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tín chỉ</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tiến độ</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800">Lập trình Android (Kotlin)</span>
                                        <span class="text-xs text-slate-500 font-mono">AND-202 • HK2</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">Dr. Tech</td>
                                <td class="px-6 py-4 text-sm text-slate-600">4.0</td>
                                <td class="px-6 py-4">
                                    <div class="w-24 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-blue-500 h-full" style="width: 75%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-blue-600 uppercase">75%</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold uppercase">Đang học</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-primary hover:bg-primary-fixed p-2 rounded-lg transition-all">
                                        <span class="material-symbols-outlined text-lg">terminal</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800">C++ Nâng cao & Cấu trúc dữ liệu</span>
                                        <span class="text-xs text-slate-500 font-mono">CPP-101 • HK2</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">Prof. Binary</td>
                                <td class="px-6 py-4 text-sm text-slate-600">3.0</td>
                                <td class="px-6 py-4">
                                    <div class="w-24 bg-green-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-green-500 h-full" style="width: 100%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-green-600 uppercase">Xong</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-green-50 text-green-700 rounded-full text-[10px] font-bold uppercase">Hoàn thành</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-primary hover:bg-primary-fixed p-2 rounded-lg transition-all">
                                        <span class="material-symbols-outlined text-lg">verified</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800">Backend Master: Laravel & PHP</span>
                                        <span class="text-xs text-slate-500 font-mono">WEB-305 • HK2</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">Dev Master</td>
                                <td class="px-6 py-4 text-sm text-slate-600">3.0</td>
                                <td class="px-6 py-4">
                                    <div class="w-24 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-blue-500 h-full" style="width: 60%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-blue-600 uppercase">60%</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold uppercase">Đang học</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-primary hover:bg-primary-fixed p-2 rounded-lg transition-all">
                                        <span class="material-symbols-outlined text-lg">database</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 flex justify-between items-center bg-slate-50/30">
                    <span class="text-xs text-slate-500 font-medium">Hiển thị 3 trong số 17 khóa học</span>
                    <div class="flex gap-2">
                        <button class="p-1 border border-slate-200 rounded disabled:opacity-50" disabled><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                        <button class="p-1 border border-slate-200 rounded hover:bg-white transition-all"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>