@extends('client.quizzes.index')

@section('title', 'Phân tích kết quả - Quiz STU')

@section('content')
<div class="max-w-5xl mx-auto px-8 py-10 page-fade">
    <div class="bg-primary rounded-[2.5rem] p-8 mb-10 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="max-w-md">
                <span class="px-3 py-1 bg-secondary rounded-full text-[10px] font-bold uppercase tracking-widest">Hoàn thành bài thi</span>
                <h2 class="text-4xl font-extrabold mt-4 mb-2">Kết quả xuất sắc!</h2>
                <p class="text-blue-100/80 leading-relaxed">Bạn đã hoàn thành bài thi <b>Cấu trúc dữ liệu & Giải thuật</b> với kết quả ấn tượng, vượt qua 92% sinh viên khác.</p>
                
                <div class="flex gap-6 mt-8">
                    <div>
                        <p class="text-[10px] uppercase opacity-60 font-bold mb-1">Thời gian làm bài</p>
                        <p class="text-xl font-bold">24:15 <span class="text-xs font-normal opacity-70">/ 45p</span></p>
                    </div>
                    <div class="w-px h-10 bg-white/20"></div>
                    <div>
                        <p class="text-[10px] uppercase opacity-60 font-bold mb-1">Độ chính xác</p>
                        <p class="text-xl font-bold">90%</p>
                    </div>
                </div>
            </div>

            <div class="relative flex items-center justify-center">
                <svg class="w-40 h-40 score-circle">
                    <circle class="text-white/10" cx="80" cy="80" r="70" fill="transparent" stroke="currentColor" stroke-width="12"></circle>
                    <circle class="text-secondary" cx="80" cy="80" r="70" fill="transparent" stroke="currentColor" stroke-dasharray="440" stroke-dashoffset="44" stroke-linecap="round" stroke-width="12"></circle>
                </svg>
                <div class="absolute text-center">
                    <span id="display-score" class="text-4xl font-black italic">9.0</span>
                    <p class="text-[10px] font-bold opacity-60 uppercase">Điểm số</p>
                </div>
            </div>
        </div>
        <span class="material-symbols-outlined absolute -right-4 -bottom-4 opacity-10 text-[12rem]">auto_awesome</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-xl font-bold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined">rule</span>
                Xem lại câu hỏi
            </h3>

            <div class="bg-white rounded-3xl border border-slate-200 p-8 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <span class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center font-bold text-sm">01</span>
                    <span class="material-symbols-outlined text-green-500" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <p class="font-bold text-slate-800 mb-6">Đâu là độ phức tạp thời gian của thuật toán Sắp xếp nhanh (Quick Sort) trong trường hợp trung bình?</p>
                <div class="space-y-3">
                    <div class="p-4 rounded-xl border border-slate-100 bg-slate-50 text-sm font-mono text-slate-600">O(n)</div>
                    <div class="p-4 rounded-xl border border-green-200 bg-green-50 text-sm font-bold text-green-700 flex justify-between font-mono italic">
                        O(n log n) <span>Đáp án của bạn</span>
                    </div>
                    <div class="p-4 rounded-xl border border-slate-100 bg-slate-50 text-sm font-mono text-slate-600">O(n²)</div>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <h4 class="font-bold text-primary mb-6">Mức độ thành thạo</h4>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold uppercase tracking-wider">
                            <span class="text-slate-500">Sorting Algorithms</span>
                            <span class="text-primary">100%</span>
                        </div>
                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold uppercase tracking-wider">
                            <span class="text-slate-500">Data Structures</span>
                            <span class="text-primary">75%</span>
                        </div>
                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-secondary/5 rounded-[2rem] p-6 border border-dashed border-secondary/30">
                <h4 class="font-bold text-primary mb-2 text-sm">Đề xuất lộ trình</h4>
                <p class="text-[11px] text-slate-600 leading-relaxed mb-4">Refactor lại kiến thức về <b>Ngăn xếp & Hàng đợi</b> để nắm vững nguyên tắc LIFO/FIFO.</p>
                <button class="w-full py-2 bg-white border border-primary text-primary text-[10px] font-bold rounded-lg hover:bg-primary hover:text-white transition-all">
                    Xem tài liệu ôn tập
                </button>
            </div>
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-slate-200 flex justify-end gap-4">
        <button class="px-6 py-3 rounded-xl font-bold text-slate-600 hover:bg-slate-100 transition-all text-xs uppercase tracking-widest">Tải bảng điểm (PDF)</button>
        <button onclick="window.location.href='index.blade.php#home'" class="px-8 py-3 rounded-xl font-bold bg-primary text-white shadow-lg hover:-translate-y-1 transition-all text-xs uppercase tracking-widest">Quay lại Console</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Lấy điểm số từ localStorage nếu có (đồng bộ từ answer&question.blade.php)
    const savedScore = localStorage.getItem('last_exam_score');
    if (savedScore) {
        document.getElementById('display-score').innerText = savedScore;
    }
</script>
@endpush