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

<body class="bg-surface text-on-surface min-h-screen">
    @include('client.partials.sidebar')
    @include('client.partials.header')

    <main class="ml-0 md:ml-64 flex-1 flex flex-col min-h-screen pt-14 md:pt-24 px-3 md:px-8 pb-12">
        <div class="max-w-6xl w-full mx-auto page-fade">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl sm:text-3xl font-bold text-primary">Quản lý khóa học IT</h2>
                    <p class="text-sm text-slate-500 mt-1">Xem lại khóa học, tiến độ và trạng thái học tập của bạn.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 transition-all relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 mb-8">
                <div class="bg-white p-5 sm:p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-xl">terminal</span>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">Đang học</p>
                        <h3 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $stats['studying'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="bg-white p-5 sm:p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-xl">verified</span>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">Hoàn thành</p>
                        <h3 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $stats['completed'] ?? 0 }}</h3>
                    </div>
                </div>
                
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row flex-wrap justify-between gap-3">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('client.courses', ['filter' => 'all']) }}" class="filter-btn px-4 py-2 {{ $filter === 'all' ? 'bg-primary text-white' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl text-xs sm:text-sm font-bold">Tất cả</a>
                        <a href="{{ route('client.courses', ['filter' => 'studying']) }}" class="filter-btn px-4 py-2 {{ $filter === 'studying' ? 'bg-primary text-white' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl text-xs sm:text-sm font-medium">Đang học</a>
                        <a href="{{ route('client.courses', ['filter' => 'completed']) }}" class="filter-btn px-4 py-2 {{ $filter === 'completed' ? 'bg-primary text-white' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl text-xs sm:text-sm font-medium">Đã xong</a>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                        <input type="text" placeholder="Tìm tên môn hoặc ID..." class="w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-primary/10 outline-none">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm sm:text-base border-collapse">
                        <thead class="bg-slate-50/60">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-[10px] sm:text-[11px] font-semibold text-slate-400 uppercase tracking-widest">Khóa học</th>
                                <th class="px-3 sm:px-6 py-3 text-[10px] sm:text-[11px] font-semibold text-slate-400 uppercase tracking-widest hidden sm:table-cell">Giảng viên</th>
                                <th class="px-3 sm:px-6 py-3 text-[10px] sm:text-[11px] font-semibold text-slate-400 uppercase tracking-widest hidden md:table-cell">Tín chỉ</th>
                                <th class="px-3 sm:px-6 py-3 text-[10px] sm:text-[11px] font-semibold text-slate-400 uppercase tracking-widest">Tiến độ</th>
                                <th class="px-3 sm:px-6 py-3 text-[10px] sm:text-[11px] font-semibold text-slate-400 uppercase tracking-widest hidden sm:table-cell">Trạng thái</th>
                                <th class="px-3 sm:px-6 py-3 text-[10px] sm:text-[11px] font-semibold text-slate-400 uppercase tracking-widest text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($courses as $course)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-3 sm:px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="font-semibold text-slate-800">{{ $course->name }}</span>
                                        <span class="text-[10px] text-slate-500 font-mono">{{ $course->code }} • HK{{ $course->semester }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-4 text-slate-600 hidden sm:table-cell">{{ $course->instructor_name }}</td>
                                <td class="px-3 sm:px-6 py-4 text-slate-600 hidden md:table-cell">{{ $course->credits }}</td>
                                <td class="px-3 sm:px-6 py-4">
                                    <div class="w-24 sm:w-28 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500" style="width: {{ $course->progress }}%"></div>
                                    </div>
                                    <span class="text-[10px] text-blue-600 font-bold uppercase">{{ $course->progress }}%</span>
                                </td>
                                <td class="px-3 sm:px-6 py-4 hidden sm:table-cell">
                                    @if($course->status === 'completed')
                                        <span class="px-2.5 py-1 bg-green-50 text-green-700 rounded-full text-[10px] font-bold uppercase">Hoàn thành</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold uppercase">Đang học</span>
                                    @endif
                                </td>
                                <td class="px-3 sm:px-6 py-4 text-right">
                                    <button class="text-primary hover:bg-primary-fixed p-2 rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-base">{{ $course->icon }}</span>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    Chưa có khóa học nào để hiển thị.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-slate-50/30">
                    <span class="text-xs text-slate-500 font-medium">Hiển thị {{ $courses->count() }} trong {{ $results->total() }} khóa học</span>
                    <div class="flex gap-2">
                        @if($results->hasPages())
                            @if($results->onFirstPage())
                                <button class="p-2 border border-slate-200 rounded-lg disabled:opacity-50" disabled><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                            @else
                                <a href="{{ $results->appends(['filter' => $filter])->previousPageUrl() }}" class="p-2 border border-slate-200 rounded-lg hover:bg-white transition-all"><span class="material-symbols-outlined text-sm">chevron_left</span></a>
                            @endif
                            @if($results->hasMorePages())
                                <a href="{{ $results->appends(['filter' => $filter])->nextPageUrl() }}" class="p-2 border border-slate-200 rounded-lg hover:bg-white transition-all"><span class="material-symbols-outlined text-sm">chevron_right</span></a>
                            @else
                                <button class="p-2 border border-slate-200 rounded-lg disabled:opacity-50" disabled><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                            @endif
                        @else
                            <button class="p-2 border border-slate-200 rounded-lg disabled:opacity-50" disabled><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                            <button class="p-2 border border-slate-200 rounded-lg disabled:opacity-50" disabled><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Filter button navigation
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            let currentIndex = 0;

            // Set initial focus based on active button
            filterButtons.forEach((btn, index) => {
                if (btn.classList.contains('bg-primary')) {
                    currentIndex = index;
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                    e.preventDefault();
                    
                    if (e.key === 'ArrowLeft') {
                        currentIndex = currentIndex > 0 ? currentIndex - 1 : filterButtons.length - 1;
                    } else {
                        currentIndex = currentIndex < filterButtons.length - 1 ? currentIndex + 1 : 0;
                    }
                    
                    filterButtons[currentIndex].focus();
                }
                
                if (e.key === 'Enter') {
                    const focused = document.activeElement;
                    if (focused.classList.contains('filter-btn')) {
                        focused.click();
                    }
                }
            });

            // Add tabindex and class
            filterButtons.forEach(btn => {
                btn.classList.add('filter-btn');
                btn.setAttribute('tabindex', '0');
            });
        });
    </script>

    @include('client.partials.mobile-menu-script')
</body>

</html>