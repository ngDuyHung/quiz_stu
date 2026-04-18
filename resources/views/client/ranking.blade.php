@extends('client.quizzes.index')

@section('title', 'Bảng điểm - Quiz STU')

@section('content')
    <div class="space-y-8 page-fade">
        <div class="mb-10">
            <h2 class="text-4xl font-bold text-primary mb-2">Bảng Xếp Hạng</h2>
            <p class="text-slate-500">Top sinh viên xuất sắc trong học kỳ hiện tại</p>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-gradient-to-r from-primary/10 to-secondary/10 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Xếp hạng</th>
                        <th class="px-8 py-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Sinh viên</th>
                        <th class="px-8 py-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">MSSV</th>
                        <th class="px-8 py-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Lớp</th>
                        <th class="px-8 py-6 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">Điểm TB</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rankings as $ranking)
                    <tr class="hover:bg-primary/5 transition-colors {{ $ranking->is_current_user ? 'bg-primary/5' : '' }}">
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center">
                                @if($ranking->rank === 1)
                                    <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 font-bold flex items-center justify-center text-sm">🥇</span>
                                @elseif($ranking->rank === 2)
                                    <span class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold flex items-center justify-center text-sm">🥈</span>
                                @elseif($ranking->rank === 3)
                                    <span class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 font-bold flex items-center justify-center text-sm">🥉</span>
                                @else
                                    <span class="w-8 h-8 rounded-full {{ $ranking->is_current_user ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600' }} font-bold flex items-center justify-center text-sm">{{ $ranking->rank }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <img src="{{ $ranking->avatar }}" class="w-10 h-10 rounded-full object-cover border-2 {{ $ranking->is_current_user ? 'border-primary' : 'border-primary/10' }}" />
                                <div>
                                    <p class="font-bold {{ $ranking->is_current_user ? 'text-primary' : 'text-slate-800' }}">{{ $ranking->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $ranking->major }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-mono text-slate-600">{{ $ranking->student_id }}</td>
                        <td class="px-8 py-6 text-sm text-slate-600">{{ $ranking->class }}</td>
                        <td class="px-8 py-6 text-right">
                            <span class="px-3 py-1 rounded-full {{ $ranking->is_current_user ? 'bg-primary text-white' : 'bg-green-100 text-green-700' }} font-bold text-sm">{{ $ranking->avg_score }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-8 text-center text-slate-500">
                            Chưa có dữ liệu xếp hạng.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-200 p-8 rounded-[2rem] shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Điểm TB Cao Nhất</p>
                    <span class="material-symbols-outlined text-primary text-2xl">trending_up</span>
                </div>
                <p class="text-3xl font-bold text-primary">{{ $stats['highest_score'] }}</p>
                <p class="text-xs text-slate-500 mt-2">{{ $stats['highest_name'] }}</p>
            </div>

            <div class="bg-white border border-slate-200 p-8 rounded-[2rem] shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Điểm TB Trung Bình</p>
                    <span class="material-symbols-outlined text-secondary text-2xl">bar_chart</span>
                </div>
                <p class="text-3xl font-bold text-secondary">{{ $stats['average_score'] }}</p>
                <p class="text-xs text-slate-500 mt-2">Toàn khối CNTT</p>
            </div>

            <div class="bg-white border border-slate-200 p-8 rounded-[2rem] shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Vị Trí Của Bạn</p>
                    <span class="material-symbols-outlined text-primary text-2xl">emoji_events</span>
                </div>
                <p class="text-3xl font-bold text-primary">{{ $stats['current_user_rank'] ?? 'N/A' }}/{{ $stats['total_students'] }}</p>
                <p class="text-xs text-slate-500 mt-2">Điểm: {{ $stats['current_user_score'] }}</p>
            </div>
        </div>
    </div>
@endsection
