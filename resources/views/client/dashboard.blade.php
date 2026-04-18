@extends('client.quizzes.index')

@section('title', 'Dashboard - Quiz STU')

@section('content')
<div class="space-y-8 sm:space-y-10 page-fade px-3 sm:px-0">

    {{-- ─── Welcome Banner ─── --}}
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-4 sm:gap-6">
        <div>
            <span class="text-[10px] sm:text-[11px] font-bold tracking-[0.2em] text-secondary uppercase mb-2 sm:mb-3 block">Dashboard Overview</span>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-primary tracking-tight mb-2 sm:mb-3">
                Chào, {{ $user->first_name }} {{ $user->last_name }}!
            </h1>
            <p class="text-xs sm:text-base text-slate-500 max-w-xl leading-relaxed">
                @if($stats['active'] > 0)
                    Bạn có <span class="text-primary font-bold">{{ $stats['active'] }} bài thi đang mở</span>.
                    @if($stats['completed'] > 0)
                        Đã hoàn thành <span class="font-bold text-green-600">{{ $stats['completed'] }}</span> lần thi với tỉ lệ trung bình <span class="font-bold text-primary">{{ number_format($stats['avg_score'], 1) }}%</span>.
                    @endif
                @else
                    Hiện không có bài thi nào đang mở.
                    @if($stats['completed'] > 0) Đã hoàn thành {{ $stats['completed'] }} lần thi. @endif
                @endif
            </p>
        </div>
        <a href="{{ route('client.exams') }}"
           class="flex-shrink-0 flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl border border-primary text-primary text-xs sm:text-sm font-bold hover:bg-primary hover:text-white transition-all">
            <span class="material-symbols-outlined text-base">assignment</span>
            Tất cả bài thi
        </a>
    </div>

    {{-- ─── Stats cards ─── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-base sm:text-lg">play_circle</span>
            </div>
            <div>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">Bài thi đang mở</p>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-800">{{ $stats['active'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Lần thi hoàn thành</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['completed'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined">percent</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Tỉ lệ đúng TB</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['avg_score'], 1) }}%</h3>
            </div>
        </div>
    </div>

    {{-- ─── Active Quizzes with Countdown ─── --}}
    @if($activeQuizzes->isNotEmpty())
    <div>
        <div class="flex items-center justify-between mb-3 sm:mb-5">
            <h2 class="text-xl sm:text-2xl font-black text-primary">Bài thi đang mở</h2>
            <span class="text-[9px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $activeQuizzes->count() }} bài</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            @foreach($activeQuizzes as $quiz)
                @php
                    $attemptCount = $quiz->attempt_count;
                    $maxAttempts  = $quiz->max_attempts;
                    $remaining    = $maxAttempts ? max(0, $maxAttempts - $attemptCount) : null;
                    $exhausted    = $maxAttempts && $attemptCount >= $maxAttempts;
                    $inProgress   = (bool) $quiz->open_result;
                @endphp
                <div class="bg-white border border-slate-200/60 rounded-[2rem] p-7 hover:shadow-xl hover:shadow-slate-200/50 transition-all relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-bl-full transition-all group-hover:scale-110"></div>

                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-4 relative z-10">
                        <div>
                            @if($inProgress)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold uppercase tracking-widest">Đang làm dở</span>
                            @elseif($exhausted)
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase tracking-widest">Đã làm hết lượt</span>
                            @elseif($maxAttempts)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-widest">Còn {{ $remaining }} lần</span>
                            @else
                                <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-bold uppercase tracking-widest">Đang mở</span>
                            @endif
                        </div>
                        @if($quiz->end_date)
                            <div class="text-right">
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Kết thúc sau</p>
                                <p class="text-sm font-black text-error countdown-timer font-mono"
                                   data-end="{{ $quiz->end_date->toIso8601String() }}">--:--:--</p>
                            </div>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h3 class="text-xl font-black text-primary mb-2 relative z-10 leading-snug">{{ $quiz->title }}</h3>

                    {{-- Meta --}}
                    <div class="flex flex-wrap gap-4 mb-6 relative z-10">
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium">
                            <span class="material-symbols-outlined text-sm text-secondary">timer</span>
                            {{ $quiz->duration_minutes }} phút
                        </div>
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium">
                            <span class="material-symbols-outlined text-sm text-secondary">quiz</span>
                            {{ $quiz->total_questions }} câu
                        </div>
                        @if($quiz->pass_percent)
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium">
                            <span class="material-symbols-outlined text-sm text-secondary">grade</span>
                            Đạt {{ $quiz->pass_percent }}%
                        </div>
                        @endif
                        @if($quiz->require_camera)
                        <div class="flex items-center gap-1.5 text-slate-500 text-xs font-medium">
                            <span class="material-symbols-outlined text-sm text-amber-500">videocam</span>
                            Yêu cầu camera
                        </div>
                        @endif
                    </div>

                    {{-- Action --}}
                    <div class="relative z-10">
                        @if($inProgress)
                            <a href="{{ route('client.quiz.take', [$quiz->id, $quiz->open_result->id]) }}"
                               class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                <span class="material-symbols-outlined text-base">play_arrow</span>
                                Tiếp tục làm
                            </a>
                        @elseif(! $exhausted)
                            <a href="{{ route('client.quiz.start', $quiz->id) }}"
                               class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-2xl font-bold text-sm hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all">
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                                {{ $attemptCount > 0 ? 'Làm lại' : 'Làm bài ngay' }}
                            </a>
                        @else
                            <span class="text-slate-400 text-sm">Không còn lượt làm.</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ─── Upcoming Quizzes ─── --}}
    @if($upcomingQuizzes->isNotEmpty())
    <div>
        <h2 class="text-2xl font-black text-primary mb-5">Sắp diễn ra</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($upcomingQuizzes as $quiz)
            <div class="bg-white border border-dashed border-slate-200 rounded-[2rem] p-6 opacity-80">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-amber-500 text-base">schedule</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-amber-600">Chưa mở</span>
                </div>
                <h4 class="font-bold text-slate-700 mb-2 leading-snug">{{ $quiz->title }}</h4>
                <p class="text-xs text-slate-400">
                    Mở lúc: <span class="font-semibold text-slate-600">{{ $quiz->start_date->format('H:i · d/m/Y') }}</span>
                </p>
                @if($quiz->end_date)
                <p class="text-xs text-slate-400 mt-0.5">
                    Đến: <span class="font-semibold text-slate-600">{{ $quiz->end_date->format('H:i · d/m/Y') }}</span>
                </p>
                @endif
                <div class="flex items-center gap-3 mt-4 text-xs text-slate-500 font-medium">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs">timer</span>{{ $quiz->duration_minutes }}p</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs">quiz</span>{{ $quiz->total_questions }} câu</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Empty state when no quizzes at all --}}
    @if($activeQuizzes->isEmpty() && $upcomingQuizzes->isEmpty())
    <div class="bg-white rounded-3xl border border-slate-200 p-16 text-center">
        <span class="material-symbols-outlined text-6xl text-slate-300 block mb-4">assignment</span>
        <h3 class="text-xl font-bold text-slate-600 mb-2">Chưa có bài thi nào</h3>
        <p class="text-slate-400 text-sm">Bạn chưa được thêm vào nhóm thi nào hoặc chưa có bài thi nào được mở.</p>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
// Countdown timers
function tickCountdowns() {
    document.querySelectorAll('.countdown-timer').forEach(el => {
        const end = new Date(el.dataset.end).getTime();
        const diff = end - Date.now();
        if (diff <= 0) {
            el.textContent = 'Đã hết hạn';
            el.classList.remove('text-error');
            el.classList.add('text-slate-400');
            return;
        }
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        el.textContent = (h > 0 ? String(h).padStart(2,'0') + ':' : '') +
            String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    });
}
tickCountdowns();
setInterval(tickCountdowns, 1000);
</script>
@endpush