@extends('client.quizzes.index')

@section('title', 'Kết quả bài thi - Quiz STU')

@section('content')
@php
    $pct           = (float) $result->percentage;
    $circumference = 2 * M_PI * 70; // r=70 → ~439.82
    $dashOffset    = $circumference * (1 - $pct / 100);
@endphp

<div class="max-w-5xl mx-auto px-4 py-10 page-fade">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 px-5 py-4 rounded-2xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="mb-6 flex items-center gap-3 px-5 py-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-700 text-sm font-medium">
            <span class="material-symbols-outlined text-blue-500">info</span>
            {{ session('info') }}
        </div>
    @endif

    {{-- ─── Hero banner ─── --}}
    <div class="bg-primary rounded-[2.5rem] p-8 mb-10 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="max-w-md">
                {{-- Status badge --}}
                @if($result->status === 'expired')
                    <span class="px-3 py-1 bg-orange-500 rounded-full text-[10px] font-bold uppercase tracking-widest">Hết giờ – nộp tự động</span>
                @elseif($passed)
                    <span class="px-3 py-1 bg-green-500 rounded-full text-[10px] font-bold uppercase tracking-widest">Đạt yêu cầu</span>
                @else
                    <span class="px-3 py-1 bg-red-500 rounded-full text-[10px] font-bold uppercase tracking-widest">Chưa đạt</span>
                @endif
                <h2 class="text-3xl font-extrabold mt-4 mb-2">
                    @if($passed) Hoàn thành xuất sắc! @else Cần cố gắng thêm @endif
                </h2>
                <p class="text-blue-100/80 leading-relaxed text-sm">
                    Bài thi: <b>{{ $quiz->title }}</b>
                    @if($quiz->pass_percent)
                        · Điểm qua: <b>{{ $quiz->pass_percent }}%</b>
                    @endif
                </p>

                <div class="flex flex-wrap gap-6 mt-8">
                    <div>
                        <p class="text-[10px] uppercase opacity-60 font-bold mb-1">Thời gian làm bài</p>
                        <p class="text-xl font-bold">
                            {{ $timeTaken }}
                            <span class="text-xs font-normal opacity-70">/ {{ $quiz->duration_minutes }}p</span>
                        </p>
                    </div>
                    <div class="w-px h-10 bg-white/20"></div>
                    <div>
                        <p class="text-[10px] uppercase opacity-60 font-bold mb-1">Số câu đúng</p>
                        <p class="text-xl font-bold">
                            {{ $resultAnswers->filter(fn($ra) => $ra->selected_option_id && $ra->selectedOption?->is_correct)->count() }}
                            <span class="text-xs font-normal opacity-70">/ {{ $resultAnswers->count() }}</span>
                        </p>
                    </div>
                    <div class="w-px h-10 bg-white/20"></div>
                    <div>
                        <p class="text-[10px] uppercase opacity-60 font-bold mb-1">Điểm số</p>
                        <p class="text-xl font-bold">{{ number_format($result->score, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- SVG score circle --}}
            <div class="relative flex items-center justify-center flex-shrink-0">
                <svg class="w-40 h-40 -rotate-90" viewBox="0 0 160 160">
                    <circle cx="80" cy="80" r="70" fill="transparent"
                        stroke="rgba(255,255,255,0.15)" stroke-width="12"/>
                    <circle cx="80" cy="80" r="70" fill="transparent"
                        stroke="{{ $passed ? '#4ade80' : '#f87171' }}"
                        stroke-dasharray="{{ number_format($circumference, 2) }}"
                        stroke-dashoffset="{{ number_format($dashOffset, 2) }}"
                        stroke-linecap="round" stroke-width="12"
                        style="transition: stroke-dashoffset 1s ease"/>
                </svg>
                <div class="absolute text-center">
                    <span class="text-4xl font-black italic">{{ number_format($pct, 0) }}<span class="text-lg">%</span></span>
                    <p class="text-[10px] font-bold opacity-60 uppercase">Tỉ lệ</p>
                </div>
            </div>
        </div>
        <span class="material-symbols-outlined absolute -right-4 -bottom-4 opacity-10 text-[12rem]">{{ $passed ? 'emoji_events' : 'school' }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ─── Left col: question review / no-answer summary ─── --}}
        <div class="lg:col-span-2 space-y-6">

            @if($quiz->show_answer)
                <h3 class="text-xl font-bold text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">rule</span>
                    Xem lại câu hỏi ({{ $resultAnswers->count() }} câu)
                </h3>

                @foreach($resultAnswers as $i => $ra)
                    @php
                        $isCorrect  = $ra->selected_option_id && $ra->selectedOption?->is_correct;
                        $isSkipped  = ! $ra->selected_option_id;
                    @endphp
                    <div class="bg-white rounded-3xl border {{ $isCorrect ? 'border-green-200' : ($isSkipped ? 'border-slate-200' : 'border-red-200') }} p-6 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <span class="w-8 h-8 rounded-lg {{ $isCorrect ? 'bg-green-50 text-green-600' : ($isSkipped ? 'bg-slate-100 text-slate-500' : 'bg-red-50 text-red-600') }} flex items-center justify-center font-bold text-sm">
                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            @if($isCorrect)
                                <span class="material-symbols-outlined text-green-500 text-xl" style="font-variation-settings:'FILL' 1">check_circle</span>
                            @elseif($isSkipped)
                                <span class="material-symbols-outlined text-slate-400 text-xl">radio_button_unchecked</span>
                            @else
                                <span class="material-symbols-outlined text-red-500 text-xl" style="font-variation-settings:'FILL' 1">cancel</span>
                            @endif
                        </div>

                        <p class="font-semibold text-slate-800 mb-4 text-sm leading-relaxed">{!! $ra->question->content !!}</p>

                        <div class="space-y-2">
                            @foreach($ra->question->options as $opt)
                                @php
                                    $wasSelected  = $ra->selected_option_id == $opt->id;
                                    $isTheCorrect = (bool) $opt->is_correct;

                                    if ($isTheCorrect && $wasSelected) {
                                        $cls   = 'border-green-300 bg-green-50 text-green-700 font-bold';
                                        $label = 'Đáp án đúng · Bạn chọn';
                                    } elseif ($isTheCorrect) {
                                        $cls   = 'border-green-200 bg-green-50/60 text-green-600 font-semibold';
                                        $label = 'Đáp án đúng';
                                    } elseif ($wasSelected) {
                                        $cls   = 'border-red-300 bg-red-50 text-red-600 font-bold';
                                        $label = 'Bạn chọn · Sai';
                                    } else {
                                        $cls   = 'border-slate-100 bg-slate-50 text-slate-600';
                                        $label = null;
                                    }
                                @endphp
                                <div class="p-3 rounded-xl border {{ $cls }} text-sm flex justify-between items-center gap-2">
                                    <span>{!! $opt->content !!}</span>
                                    @if($label)
                                        <span class="text-[10px] whitespace-nowrap font-bold uppercase tracking-wider opacity-80">{{ $label }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            @else
                <div class="bg-white rounded-3xl border border-slate-200 p-10 text-center">
                    <span class="material-symbols-outlined text-5xl text-slate-300 mb-4 block">visibility_off</span>
                    <h4 class="font-bold text-slate-700 text-lg mb-2">Đáp án không được hiển thị</h4>
                    <p class="text-slate-500 text-sm">Giảng viên đã tắt chức năng xem lại đáp án cho bài thi này.</p>
                </div>
            @endif

        </div>

        {{-- ─── Right col: stats + feedback ─── --}}
        <div class="space-y-6">

            {{-- Score summary card --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h4 class="font-bold text-primary mb-4 text-sm uppercase tracking-wider">Tóm tắt kết quả</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Trạng thái</span>
                        @if($passed)
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold text-xs">Đạt</span>
                        @else
                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-bold text-xs">Chưa đạt</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Điểm số</span>
                        <span class="font-bold text-primary">{{ number_format($result->score, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Tỉ lệ</span>
                        <span class="font-bold text-primary">{{ number_format($pct, 1) }}%</span>
                    </div>
                    @if($quiz->pass_percent)
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Điểm qua</span>
                        <span class="font-semibold text-slate-600">{{ $quiz->pass_percent }}%</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Thời gian</span>
                        <span class="font-semibold text-slate-600">{{ $timeTaken }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Nộp lúc</span>
                        <span class="font-semibold text-slate-600 text-xs">{{ $result->ended_at?->format('H:i d/m/Y') ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Category mastery (only when show_answer = true) --}}
            @if($quiz->show_answer && count($categoryStats) > 0)
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h4 class="font-bold text-primary mb-4 text-sm uppercase tracking-wider">Mức độ thành thạo</h4>
                <div class="space-y-4">
                    @foreach($categoryStats as $catName => $stat)
                        @php
                            $catPct   = $stat['total'] > 0 ? round($stat['correct'] / $stat['total'] * 100) : 0;
                            $barColor = $catPct >= 70 ? 'bg-green-500' : ($catPct >= 40 ? 'bg-yellow-400' : 'bg-red-400');
                        @endphp
                        <div class="space-y-1.5">
                            <div class="flex justify-between text-xs font-bold uppercase tracking-wider">
                                <span class="text-slate-500 truncate max-w-[70%]">{{ $catName }}</span>
                                <span class="text-primary">{{ $catPct }}%</span>
                            </div>
                            <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full {{ $barColor }} rounded-full" style="width: {{ $catPct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Feedback form (only for completed, not expired) --}}
            @if($result->status === 'completed')
            <div id="feedback" class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h4 class="font-bold text-primary mb-1 text-sm uppercase tracking-wider">Phản hồi bài thi</h4>
                @if($hasFeedback)
                    <div class="flex items-center gap-2 mt-3 text-green-600 text-sm">
                        <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">check_circle</span>
                        <span>Bạn đã gửi phản hồi. Cảm ơn!</span>
                    </div>
                @else
                    <p class="text-slate-500 text-xs mb-4">Đánh giá chất lượng đề thi để giúp cải thiện hệ thống.</p>
                    <form method="POST" action="{{ route('client.quiz.feedback', $result->id) }}" id="feedbackForm">
                        @csrf
                        <div class="space-y-4">
                            @php
                                $feedbackFields = [
                                    'formality_score' => 'Hình thức đề thi',
                                    'time_score'      => 'Thời gian hợp lý',
                                    'content_score'   => 'Nội dung phù hợp',
                                    'presenter_score' => 'Cách trình bày câu hỏi',
                                ];
                            @endphp
                            @foreach($feedbackFields as $fieldName => $fieldLabel)
                            <div>
                                <p class="text-xs font-semibold text-slate-600 mb-1.5">{{ $fieldLabel }}</p>
                                <div class="flex gap-1">
                                    @for($s = 1; $s <= 5; $s++)
                                    <button type="button"
                                        class="star-btn text-2xl text-slate-300 hover:text-yellow-400 transition-colors"
                                        data-field="{{ $fieldName }}" data-value="{{ $s }}">
                                        <span class="material-symbols-outlined" style="font-size:1.3rem">star</span>
                                    </button>
                                    @endfor
                                    <input type="hidden" name="{{ $fieldName }}" id="{{ $fieldName }}" value="">
                                </div>
                                @error($fieldName)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            @endforeach

                            <div>
                                <p class="text-xs font-semibold text-slate-600 mb-1.5">Góp ý thêm (tùy chọn)</p>
                                <textarea name="suggestion" rows="2"
                                    class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 resize-none focus:outline-none focus:border-primary"
                                    placeholder="Nhập ý kiến của bạn...">{{ old('suggestion') }}</textarea>
                            </div>

                            <button type="submit" id="feedbackSubmitBtn"
                                class="w-full py-2.5 bg-primary text-white text-xs font-bold rounded-xl hover:-translate-y-0.5 transition-all shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Gửi phản hồi
                            </button>
                        </div>
                    </form>
                @endif
            </div>
            @endif

        </div>{{-- end right col --}}
    </div>

    {{-- ─── Footer actions ─── --}}
    <div class="mt-10 pt-8 border-t border-slate-200 flex flex-wrap justify-end gap-4">
        @if($canRetry)
            <a href="{{ route('client.quiz.start', $quiz->id) }}"
               class="px-6 py-3 rounded-xl font-bold text-primary border border-primary hover:bg-primary hover:text-white transition-all text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined align-middle text-base mr-1">replay</span>Làm lại
            </a>
        @endif
        <a href="{{ route('client.exams') }}"
           class="px-8 py-3 rounded-xl font-bold bg-primary text-white shadow-lg hover:-translate-y-1 transition-all text-xs uppercase tracking-widest">
            <span class="material-symbols-outlined align-middle text-base mr-1">home</span>Về trang bài thi
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
// ─── Star Rating ───────────────────────────────────────────────────────
const starGroups = {};
document.querySelectorAll('.star-btn').forEach(btn => {
    const field = btn.dataset.field;
    if (!starGroups[field]) starGroups[field] = [];
    starGroups[field].push(btn);

    btn.addEventListener('click', () => {
        const val = parseInt(btn.dataset.value);
        document.getElementById(field).value = val;

        starGroups[field].forEach((b, idx) => {
            const icon = b.querySelector('.material-symbols-outlined');
            if (idx < val) {
                b.classList.remove('text-slate-300');
                b.classList.add('text-yellow-400');
                icon.style.fontVariationSettings = "'FILL' 1";
            } else {
                b.classList.remove('text-yellow-400');
                b.classList.add('text-slate-300');
                icon.style.fontVariationSettings = "'FILL' 0";
            }
        });

        checkFeedbackReady();
    });
});

function checkFeedbackReady() {
    const required = ['formality_score', 'time_score', 'content_score', 'presenter_score'];
    const allFilled = required.every(f => {
        const el = document.getElementById(f);
        return el && el.value !== '';
    });
    const btn = document.getElementById('feedbackSubmitBtn');
    if (btn) btn.disabled = !allFilled;
}
</script>
@endpush