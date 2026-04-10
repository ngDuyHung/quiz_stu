@extends('client.quizzes.index')

@section('title', 'Lịch sử thi - Quiz STU')

@section('content')
<div class="space-y-8 page-fade">

    <div class="mb-8">
        <h2 class="text-4xl font-bold text-primary mb-2">Lịch sử thi</h2>
        <p class="text-slate-500">Tất cả các lần thi của bạn, sắp xếp mới nhất trước</p>
    </div>

    @if($results->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-200 p-16 text-center">
            <span class="material-symbols-outlined text-6xl text-slate-300 block mb-4">history</span>
            <h3 class="text-xl font-bold text-slate-600 mb-2">Chưa có lịch sử thi</h3>
            <p class="text-slate-400 text-sm mb-6">Bạn chưa hoàn thành bài thi nào.</p>
            <a href="{{ route('client.exams') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:-translate-y-0.5 transition-all shadow-md">
                <span class="material-symbols-outlined text-base">assignment</span>
                Xem danh sách bài thi
            </a>
        </div>
    @else
        {{-- Summary stats --}}
        @php
            $totalCount   = $results->count();
            $passedCount  = $results->filter(fn($r) => $r->passed === true)->count();
            $avgPct       = $results->avg('percentage');
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined">grading</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Tổng lần thi</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $totalCount }}</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined">emoji_events</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Số lần đạt</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $passedCount }}</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined">percent</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Tỉ lệ TB</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ number_format($avgPct, 1) }}%</h3>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/70">
                            <th class="text-left px-6 py-4 font-bold text-slate-500 uppercase tracking-wider text-xs">#</th>
                            <th class="text-left px-6 py-4 font-bold text-slate-500 uppercase tracking-wider text-xs">Tên bài thi</th>
                            <th class="text-left px-6 py-4 font-bold text-slate-500 uppercase tracking-wider text-xs">Ngày thi</th>
                            <th class="text-center px-4 py-4 font-bold text-slate-500 uppercase tracking-wider text-xs">Điểm</th>
                            <th class="text-center px-4 py-4 font-bold text-slate-500 uppercase tracking-wider text-xs">Tỉ lệ</th>
                            <th class="text-center px-4 py-4 font-bold text-slate-500 uppercase tracking-wider text-xs">Thời gian</th>
                            <th class="text-center px-4 py-4 font-bold text-slate-500 uppercase tracking-wider text-xs">Trạng thái</th>
                            <th class="text-center px-4 py-4 font-bold text-slate-500 uppercase tracking-wider text-xs">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($results as $i => $result)
                            @php
                                $totalSec = $result->total_seconds ?? 0;
                                $timeTaken = sprintf('%02d:%02d', intdiv($totalSec, 60), $totalSec % 60);
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                {{-- # --}}
                                <td class="px-6 py-4 text-slate-400 font-medium">{{ $i + 1 }}</td>

                                {{-- Tên bài thi --}}
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 leading-snug">{{ $result->quiz->title }}</div>
                                    @if(! $result->has_feedback && $result->status === 'completed')
                                        <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-wider">
                                            <span class="material-symbols-outlined text-[10px]">warning</span>
                                            Chưa phản hồi
                                        </span>
                                    @endif
                                </td>

                                {{-- Ngày thi --}}
                                <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                    {{ $result->ended_at?->format('H:i · d/m/Y') ?? $result->created_at->format('d/m/Y') }}
                                </td>

                                {{-- Điểm --}}
                                <td class="px-4 py-4 text-center">
                                    <span class="font-bold text-primary">{{ number_format($result->score, 2) }}</span>
                                </td>

                                {{-- Tỉ lệ --}}
                                <td class="px-4 py-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="font-semibold text-slate-700">{{ number_format($result->percentage, 1) }}%</span>
                                        <div class="w-16 h-1 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ $result->passed === true ? 'bg-green-500' : ($result->passed === false ? 'bg-red-400' : 'bg-blue-400') }}"
                                                 style="width: {{ min(100, $result->percentage) }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Thời gian --}}
                                <td class="px-4 py-4 text-center text-slate-500 whitespace-nowrap font-mono text-xs">
                                    {{ $timeTaken }}
                                </td>

                                {{-- Trạng thái --}}
                                <td class="px-4 py-4 text-center">
                                    @if($result->status === 'expired')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                            <span class="material-symbols-outlined text-xs">timer_off</span>
                                            Hết giờ
                                        </span>
                                    @elseif($result->passed === true)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            <span class="material-symbols-outlined text-xs" style="font-variation-settings:'FILL' 1">check_circle</span>
                                            Đạt
                                        </span>
                                    @elseif($result->passed === false)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            <span class="material-symbols-outlined text-xs" style="font-variation-settings:'FILL' 1">cancel</span>
                                            Không đạt
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                            <span class="material-symbols-outlined text-xs">check</span>
                                            Hoàn thành
                                        </span>
                                    @endif
                                </td>

                                {{-- Hành động --}}
                                <td class="px-4 py-4 text-center">
                                    @if($result->quiz->show_answer)
                                        <a href="{{ route('client.quiz.result', $result->id) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary/10 text-primary font-bold text-xs hover:bg-primary hover:text-white transition-all">
                                            <span class="material-symbols-outlined text-xs">open_in_new</span>
                                            Xem chi tiết
                                        </a>
                                    @else
                                        <span class="text-slate-300 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
