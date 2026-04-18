@extends('client.quizzes.index')

@section('title', 'Danh sách bài thi - Quiz STU')

@section('content')
    <div class="space-y-6 sm:space-y-8 page-fade px-3 sm:px-0">
        <div class="mb-6 sm:mb-10">
            <h2 class="text-2xl sm:text-4xl font-bold text-primary mb-2">Danh sách Bài Thi</h2>
            <p class="text-xs sm:text-base text-slate-500">Tất cả các bài thi đang mở và các kỳ thi đã qua</p>
        </div>

        {{-- Flash messages --}}
        @foreach (['error' => 'bg-error/10 border-error/30 text-error', 'success' => 'bg-green-50 border-green-200 text-green-700', 'info' => 'bg-blue-50 border-blue-200 text-blue-700'] as $type => $classes)
            @if(session($type))
                <div class="flex items-center gap-3 px-5 py-4 rounded-2xl border {{ $classes }} mb-2">
                    <span class="material-symbols-outlined text-xl">
                        {{ $type === 'error' ? 'error' : ($type === 'success' ? 'check_circle' : 'info') }}
                    </span>
                    <span class="font-medium">{{ session($type) }}</span>
                </div>
            @endif
        @endforeach

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-8 sm:mb-10">
            <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-base sm:text-lg">play_circle</span>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">Đang mở</p>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-800">{{ $stats['active'] }}</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Đã hoàn thành</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $stats['completed'] }}</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">percent</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Tỷ lệ đúng TB</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['avg_score'], 1) }}%</h3>
                </div>
            </div>
        </div>

        {{-- Exam list --}}
        <div class="space-y-4">
            @forelse($quizzes as $quiz)
                @php
                    if ($quiz->open_result) {
                        $badgeClass = 'bg-amber-100 text-amber-700';
                        $badgeText  = 'Đang làm';
                        $badgeIcon  = 'pending';
                    } elseif ($quiz->is_upcoming) {
                        $badgeClass = 'bg-blue-100 text-blue-700';
                        $badgeText  = 'Sắp diễn ra';
                        $badgeIcon  = 'schedule';
                    } elseif ($quiz->is_ended) {
                        $badgeClass = 'bg-slate-100 text-slate-500';
                        $badgeText  = 'Đã kết thúc';
                        $badgeIcon  = 'lock';
                    } elseif ($quiz->last_result) {
                        $badgeClass = 'bg-green-100 text-green-700';
                        $badgeText  = 'Đã hoàn thành';
                        $badgeIcon  = 'check_circle';
                    } else {
                        $badgeClass = 'bg-error/10 text-error';
                        $badgeText  = 'Đang mở';
                        $badgeIcon  = 'play_arrow';
                    }
                @endphp

                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 hover:shadow-lg transition-all group {{ $quiz->is_ended && !$quiz->last_result ? 'opacity-60' : '' }}">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-4 flex-wrap">
                                <span class="px-3 py-1 {{ $badgeClass }} rounded-full text-xs font-bold uppercase tracking-widest flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm" style="font-size:14px">{{ $badgeIcon }}</span>
                                    {{ $badgeText }}
                                </span>
                                @if($quiz->open_result)
                                    <span class="text-xs font-bold text-amber-600">Bài đang dở – tiếp tục ngay</span>
                                @elseif($quiz->is_upcoming && $quiz->start_date)
                                    <span class="text-xs font-bold text-slate-400">Bắt đầu: {{ $quiz->start_date->format('d/m/Y H:i') }}</span>
                                @elseif($quiz->end_date)
                                    <span class="text-xs font-bold text-slate-400">
                                        {{ $quiz->is_active ? 'Kết thúc: ' . $quiz->end_date->format('d/m/Y H:i') : 'Đã đóng: ' . $quiz->end_date->format('d/m/Y H:i') }}
                                    </span>
                                @endif
                                @if($quiz->require_camera)
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full text-xs font-medium flex items-center gap-1">
                                        <span class="material-symbols-outlined" style="font-size:12px">videocam</span>
                                        Yêu cầu camera
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-2xl font-bold text-primary mb-2">{{ $quiz->name }}</h3>
                            @if($quiz->description)
                                <p class="text-slate-500 mb-6 leading-relaxed">{{ $quiz->description }}</p>
                            @endif

                            <div class="flex flex-wrap gap-6 mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-lg">timer</span>
                                    <div>
                                        <p class="text-[10px] text-slate-500 font-bold uppercase">Thời gian</p>
                                        <p class="font-bold text-slate-800">{{ $quiz->duration_minutes }} phút</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-lg">quiz</span>
                                    <div>
                                        <p class="text-[10px] text-slate-500 font-bold uppercase">Số câu</p>
                                        <p class="font-bold text-slate-800">{{ $quiz->total_questions }} câu</p>
                                    </div>
                                </div>
                                @if($quiz->pass_percent)
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-lg">grade</span>
                                        <div>
                                            <p class="text-[10px] text-slate-500 font-bold uppercase">Đậu từ</p>
                                            <p class="font-bold text-slate-800">{{ $quiz->pass_percent }}%</p>
                                        </div>
                                    </div>
                                @endif
                                @if($quiz->max_attempts)
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-lg">repeat</span>
                                        <div>
                                            <p class="text-[10px] text-slate-500 font-bold uppercase">Lượt còn lại</p>
                                            <p class="font-bold text-slate-800">{{ $quiz->max_attempts - $quiz->attempt_count }}/{{ $quiz->max_attempts }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($quiz->last_result)
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-green-600 text-lg">verified</span>
                                        <div>
                                            <p class="text-[10px] text-slate-500 font-bold uppercase">Điểm gần nhất</p>
                                            <p class="font-bold text-green-700">{{ number_format($quiz->last_result->percentage, 1) }}%</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="ml-6 flex-shrink-0">
                            @if($quiz->last_result && !$quiz->can_start && !$quiz->open_result)
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-green-600 text-5xl" style="font-variation-settings:'FILL' 1">check_circle</span>
                                </div>
                            @elseif($quiz->is_upcoming)
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-blue-600 text-5xl opacity-60">schedule</span>
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-5xl opacity-50">edit_note</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action button --}}
                    @if($quiz->open_result)
                        <a href="{{ route('client.quiz.take', [$quiz->id, $quiz->open_result->id]) }}"
                           class="flex items-center justify-center gap-2 w-full bg-amber-500 text-white py-3.5 rounded-xl font-bold hover:bg-amber-600 hover:shadow-lg transition-all active:scale-95">
                            <span class="material-symbols-outlined">play_arrow</span>
                            Tiếp tục làm bài
                        </a>
                    @elseif($quiz->can_start)
                        <a href="{{ route('client.quiz.start', $quiz->id) }}"
                           class="flex items-center justify-center gap-2 w-full bg-primary text-white py-3.5 rounded-xl font-bold hover:shadow-lg hover:shadow-primary/30 transition-all active:scale-95 group-hover:shadow-2xl">
                            <span class="material-symbols-outlined">play_circle</span>
                            Làm bài thi ngay
                        </a>
                    @elseif($quiz->is_upcoming)
                        <button disabled class="w-full bg-slate-100 text-slate-400 py-3.5 rounded-xl font-bold cursor-not-allowed flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">schedule</span>
                            Chưa đến giờ thi
                        </button>
                    @elseif($quiz->last_result)
                        <a href="{{ route('client.results') }}"
                           class="flex items-center justify-center gap-2 w-full bg-slate-100 text-slate-600 py-3.5 rounded-xl font-bold hover:bg-slate-200 transition-all">
                            <span class="material-symbols-outlined">assignment_turned_in</span>
                            Xem kết quả
                        </a>
                    @else
                        <button disabled class="w-full bg-slate-100 text-slate-400 py-3.5 rounded-xl font-bold cursor-not-allowed">
                            Không thể thi
                        </button>
                    @endif
                </div>
            @empty
                <div class="text-center py-24 bg-white rounded-3xl border border-slate-100">
                    <span class="material-symbols-outlined text-6xl text-slate-300 block mb-4">assignment_late</span>
                    <h3 class="text-xl font-bold text-slate-400 mb-2">Chưa có bài thi nào</h3>
                    <p class="text-slate-400 text-sm">Bạn chưa được phân vào nhóm thi nào. Vui lòng liên hệ giảng viên.</p>
                </div>
            @endforelse
        </div>

        {{-- Phần còn lại của view cũ (card 4+) đã được thay bằng vòng lặp ở trên --}}
    </div>
@endsection
