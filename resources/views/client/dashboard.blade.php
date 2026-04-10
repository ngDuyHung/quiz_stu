<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dashboard - Quiz STU</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "secondary-container": "#88c3ff",
                        "on-error": "#ffffff",
                        "surface-tint": "#335f99",
                        "primary-fixed": "#d5e3ff",
                        "outline-variant": "#c3c6d1",
                        "surface-container-low": "#f2f4f6",
                        "on-tertiary-container": "#f7a967",
                        "on-secondary-fixed-variant": "#004a79",
                        "primary-fixed-dim": "#a6c8ff",
                        "primary-container": "#1a4b84",
                        "on-primary": "#ffffff",
                        "error": "#ba1a1a",
                        "primary": "#003466",
                        "tertiary-container": "#733c00",
                        "background": "#f7f9fb",
                        "on-primary-fixed-variant": "#144780",
                        "secondary": "#1a6299",
                        "on-surface-variant": "#424750",
                        "on-primary-fixed": "#001c3b",
                        "surface-variant": "#e0e3e5",
                        "on-background": "#191c1e",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed": "#2f1500",
                        "on-secondary-fixed": "#001d34",
                        "on-error-container": "#93000a",
                        "tertiary-fixed": "#ffdcc3",
                        "surface": "#f7f9fb",
                        "inverse-primary": "#a6c8ff",
                        "surface-bright": "#f7f9fb",
                        "tertiary": "#522900",
                        "tertiary-fixed-dim": "#ffb77d",
                        "surface-container-highest": "#e0e3e5",
                        "secondary-fixed": "#cfe5ff",
                        "on-secondary-container": "#005082",
                        "on-tertiary-fixed-variant": "#6e3900",
                        "on-surface": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "surface-dim": "#d8dadc",
                        "inverse-surface": "#2d3133",
                        "outline": "#737781",
                        "surface-container-high": "#e6e8ea",
                        "secondary-fixed-dim": "#9acbff",
                        "on-primary-container": "#93bcfc",
                        "surface-container": "#eceef0",
                        "on-tertiary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Manrope', sans-serif; }
        
        /* Custom scrollbar for better UI */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e0e3e5; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #c3c6d1; }
    </style>
</head>

<body class="bg-surface text-on-background min-h-screen">
    @include('client.partials.sidebar')
    @include('client.partials.header')

    <main class="ml-64 pt-24 px-8 pb-12">
        <div class="max-w-7xl mx-auto space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                <div class="lg:col-span-8">
                    <span class="text-[11px] font-bold tracking-[0.2em] text-secondary uppercase mb-3 block">Dashboard Overview</span>
                    <h1 class="text-5xl font-extrabold text-primary tracking-tight mb-4">Chào Alex,</h1>
                    <p class="text-lg text-on-surface-variant max-w-2xl leading-relaxed">
                        Tiến độ học tập của bạn đang ở mức <span class="text-primary font-bold">85%</span>. Bạn có <span class="text-error font-bold">1 bài kiểm tra</span> sắp diễn ra trong hôm nay.
                    </p>
                </div>
                <div class="lg:col-span-4">
                    <div class="bg-tertiary-fixed p-5 rounded-[2rem] flex items-center gap-4 border border-tertiary/10 shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-tertiary shadow-sm">
                            <span class="material-symbols-outlined">event_upcoming</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-on-tertiary-fixed-variant uppercase tracking-wider">Sự kiện sắp tới</p>
                            <p class="text-sm font-bold text-on-tertiary-fixed">Thi Cuối Kỳ: Lập trình Mobile</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <div class="lg:col-span-8 bg-white border border-slate-200/60 rounded-[2.5rem] p-10 shadow-sm flex flex-col md:flex-row gap-8 items-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-secondary/5 rounded-bl-full transition-all group-hover:scale-110"></div>
                    
                    <div class="flex-1 relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="px-4 py-1 bg-error/10 text-error rounded-full text-xs font-bold uppercase tracking-widest">Đang mở</span>
                            <span class="text-xs font-bold text-slate-400">Kết thúc lúc: 23:59 Hôm nay</span>
                        </div>
                        <h2 class="text-3xl font-black text-primary mb-2">Kiểm tra Giữa kỳ: <br/>Lập trình Web Nâng cao</h2>
                        <p class="text-slate-500 mb-8 font-medium italic">"Bao gồm nội dung về ReactJS, Tailwind CSS và REST API."</p>
                        
                        <div class="flex flex-wrap gap-6 mb-8">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary">timer</span>
                                <span class="text-sm font-bold text-on-surface">60 phút</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary">quiz</span>
                                <span class="text-sm font-bold text-on-surface">40 câu hỏi</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary">star</span>
                                <span class="text-sm font-bold text-on-surface">Hệ số 0.3</span>
                            </div>
                        </div>

                        <button onclick="window.location.href='{{ route('client.answer&question') }}'" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold flex items-center gap-3 hover:shadow-2xl hover:shadow-primary/30 transition-all hover:-translate-y-1">
                            Làm bài ngay
                            <span class="material-symbols-outlined">arrow_forward_ios</span>
                        </button>
                    </div>

                    <div class="w-full md:w-48 aspect-square bg-slate-50 rounded-3xl flex items-center justify-center border border-slate-100">
                        <span class="material-symbols-outlined text-primary/20 text-8xl">code</span>
                    </div>
                </div>

                <div class="lg:col-span-4 bg-secondary text-white rounded-[2.5rem] p-10 flex flex-col justify-between shadow-xl shadow-secondary/20 relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-10">
                            <div>
                                <h3 class="text-xs font-bold opacity-70 uppercase tracking-[0.2em] mb-1">Điểm trung bình</h3>
                                <p class="text-6xl font-black italic">8.82</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-2xl backdrop-blur-md">
                                <span class="material-symbols-outlined text-3xl">analytics</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm font-bold">
                                <span>Hoàn thành mục tiêu</span>
                                <span>92%</span>
                            </div>
                            <div class="w-full h-3 bg-white/20 rounded-full overflow-hidden">
                                <div class="bg-white h-full w-[92%] shadow-[0_0_15px_rgba(255,255,255,0.5)]"></div>
                            </div>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -left-10 -bottom-10 text-[15rem] opacity-10">auto_awesome</span>
                </div>

                <div class="lg:col-span-12">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-primary">Các kỳ thi sắp diễn ra</h3>
                            <p class="text-sm text-slate-500 font-medium">Bạn có 3 môn học cần hoàn thành nội dung ôn tập.</p>
                        </div>
                        <button class="flex items-center gap-2 text-primary font-bold text-sm hover:underline">
                            Xem tất cả danh sách
                            <span class="material-symbols-outlined text-sm">open_in_new</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white border border-slate-200/50 p-6 rounded-[2rem] hover:shadow-xl hover:shadow-slate-200/50 transition-all group">
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-secondary-fixed flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl">database</span>
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Ngày 20/04</span>
                            </div>
                            <h4 class="text-lg font-bold text-primary mb-1">Cơ sở dữ liệu NoSQL</h4>
                            <p class="text-xs text-slate-500 mb-6 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">person</span>
                                GV. Nguyễn Văn A
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                <span class="text-xs font-bold text-secondary">45 Phút • 30 Câu</span>
                                <button class="p-2 bg-slate-100 rounded-xl text-primary hover:bg-primary hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">bookmark</span>
                                </button>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-200/50 p-6 rounded-[2rem] hover:shadow-xl hover:shadow-slate-200/50 transition-all group">
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-tertiary-fixed flex items-center justify-center text-tertiary group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl">security</span>
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Ngày 22/04</span>
                            </div>
                            <h4 class="text-lg font-bold text-primary mb-1">An toàn Bảo mật TT</h4>
                            <p class="text-xs text-slate-500 mb-6 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">person</span>
                                GV. Trần Thị B
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                <span class="text-xs font-bold text-secondary">60 Phút • 50 Câu</span>
                                <button class="p-2 bg-slate-100 rounded-xl text-primary hover:bg-primary hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">bookmark</span>
                                </button>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-200/50 p-6 rounded-[2rem] hover:shadow-xl hover:shadow-slate-200/50 transition-all group">
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-primary-fixed flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl">cloud_queue</span>
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Ngày 25/04</span>
                            </div>
                            <h4 class="text-lg font-bold text-primary mb-1">Điện toán Đám mây</h4>
                            <p class="text-xs text-slate-500 mb-6 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">person</span>
                                GV. Lê Văn C
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                <span class="text-xs font-bold text-secondary">40 Phút • 20 Câu</span>
                                <button class="p-2 bg-slate-100 rounded-xl text-primary hover:bg-primary hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">bookmark</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</body>

</html>