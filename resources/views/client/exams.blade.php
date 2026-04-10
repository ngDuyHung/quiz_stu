@extends('client.quizzes.index')

@section('title', 'Danh sách bài thi - Quiz STU')

@section('content')
    <div class="space-y-8 page-fade">
        <div class="mb-10">
            <h2 class="text-4xl font-bold text-primary mb-2">Danh sách Bài Thi</h2>
            <p class="text-slate-500">Tất cả các bài thi sắp diễn ra và các kỳ thi quá khứ</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">hourglass_top</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Sắp diễn ra</p>
                    <h3 class="text-2xl font-bold text-slate-800">5</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Đã hoàn thành</p>
                    <h3 class="text-2xl font-bold text-slate-800">12</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Điểm trung bình</p>
                    <h3 class="text-2xl font-bold text-slate-800">8.3</h3>
                </div>
            </div>
        </div>

        <div class="flex gap-4 mb-8">
            <button class="px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm transition-all hover:shadow-lg">Tất cả</button>
            <button class="px-6 py-2.5 text-slate-600 hover:bg-slate-100 rounded-xl font-medium text-sm transition-all">Sắp diễn ra</button>
            <button class="px-6 py-2.5 text-slate-600 hover:bg-slate-100 rounded-xl font-medium text-sm transition-all">Đã hoàn thành</button>
        </div>

        <div class="space-y-4">
            <!-- Exam Card 1 - Active -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-8 hover:shadow-lg transition-all cursor-pointer group">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-error/10 text-error rounded-full text-xs font-bold uppercase tracking-widest">Đang mở</span>
                            <span class="text-xs font-bold text-slate-400">Kết thúc: 23:59 hôm nay</span>
                        </div>
                        <h3 class="text-2xl font-bold text-primary mb-2">Kiểm tra Giữa kỳ: Lập trình Web Nâng cao</h3>
                        <p class="text-slate-600 text-sm mb-4">IT4421 • Kỳ I/2025-2026 • GV: Dr. Dev Master</p>
                        <p class="text-slate-500 mb-6">Bao gồm nội dung về ReactJS, Tailwind CSS, REST API và các khái niệm nâng cao về backend.</p>
                        
                        <div class="flex flex-wrap gap-6 mb-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">timer</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Thời gian</p>
                                    <p class="font-bold text-slate-800">60 phút</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">quiz</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Số câu</p>
                                    <p class="font-bold text-slate-800">40 câu</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">star</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Hệ số</p>
                                    <p class="font-bold text-slate-800">0.3</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-primary text-5xl opacity-50">edit_note</span>
                        </div>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('client.answer&question') }}'" class="w-full bg-primary text-white py-3.5 rounded-xl font-bold hover:shadow-lg hover:shadow-primary/30 transition-all active:scale-95 group-hover:shadow-2xl">
                    Làm bài thi ngay
                </button>
            </div>

            <!-- Exam Card 2 -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-8 hover:shadow-lg transition-all cursor-pointer group">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-widest">Sắp diễn ra</span>
                            <span class="text-xs font-bold text-slate-400">Ngày 18/04/2026 - 14:00</span>
                        </div>
                        <h3 class="text-2xl font-bold text-primary mb-2">Cơ sở dữ liệu NoSQL</h3>
                        <p class="text-slate-600 text-sm mb-4">IT4312 • Kỳ I/2025-2026 • GV: Nguyễn Văn A</p>
                        <p class="text-slate-500 mb-6">Kiến thức về MongoDB, Redis, DynamoDB và các ứng dụng thực tế của NoSQL.</p>
                        
                        <div class="flex flex-wrap gap-6 mb-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">timer</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Thời gian</p>
                                    <p class="font-bold text-slate-800">45 phút</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">quiz</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Số câu</p>
                                    <p class="font-bold text-slate-800">30 câu</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">grade</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Hệ số</p>
                                    <p class="font-bold text-slate-800">0.4</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-blue-600 text-5xl opacity-50">database</span>
                        </div>
                    </div>
                </div>
                <button class="w-full bg-slate-200 text-slate-600 py-3.5 rounded-xl font-bold cursor-not-allowed opacity-60">
                    Không thể làm bài (Sắp diễn ra)
                </button>
            </div>

            <!-- Exam Card 3 - Completed -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-8 hover:shadow-lg transition-all cursor-pointer group opacity-75">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-widest">Đã hoàn thành</span>
                            <span class="text-xs font-bold text-slate-400">Ngày 15/04/2026 • Điểm: 8.5/10</span>
                        </div>
                        <h3 class="text-2xl font-bold text-primary mb-2">An toàn Bảo mật Thông tin</h3>
                        <p class="text-slate-600 text-sm mb-4">IT4401 • Kỳ I/2025-2026 • GV: Trần Thị B</p>
                        <p class="text-slate-500 mb-6">Mã hóa, xác thực, phân quyền và các biện pháp bảo mật thông tin.</p>
                        
                        <div class="flex flex-wrap gap-6 mb-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">timer</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Thời gian</p>
                                    <p class="font-bold text-slate-800">60 phút</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">quiz</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Số câu</p>
                                    <p class="font-bold text-slate-800">50 câu</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-600 text-lg">verified</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Độ chính xác</p>
                                    <p class="font-bold text-slate-800">85%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-green-600 text-5xl" style="font-variation-settings: 'FILL' 1">check_circle</span>
                        </div>
                    </div>
                </div>
                <button class="w-full bg-slate-100 text-slate-600 py-3.5 rounded-xl font-bold">
                    Xem chi tiết kết quả
                </button>
            </div>

            <!-- Exam Card 4 -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-8 hover:shadow-lg transition-all cursor-pointer group">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase tracking-widest">Sắp diễn ra</span>
                            <span class="text-xs font-bold text-slate-400">Ngày 22/04/2026 - 09:00</span>
                        </div>
                        <h3 class="text-2xl font-bold text-primary mb-2">Điện toán Đám mây</h3>
                        <p class="text-slate-600 text-sm mb-4">IT4510 • Kỳ I/2025-2026 • GV: Lê Văn C</p>
                        <p class="text-slate-500 mb-6">AWS, Azure, Google Cloud và các dịch vụ cloud computing hiện đại.</p>
                        
                        <div class="flex flex-wrap gap-6 mb-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">timer</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Thời gian</p>
                                    <p class="font-bold text-slate-800">40 phút</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">quiz</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Số câu</p>
                                    <p class="font-bold text-slate-800">20 câu</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-lg">cloud_queue</span>
                                <div>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase">Hệ số</p>
                                    <p class="font-bold text-slate-800">0.25</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-blue-600 text-5xl opacity-50">cloud_queue</span>
                        </div>
                    </div>
                </div>
                <button class="w-full bg-slate-200 text-slate-600 py-3.5 rounded-xl font-bold cursor-not-allowed opacity-60">
                    Không thể làm bài (Sắp diễn ra)
                </button>
            </div>
        </div>
    </div>
@endsection
