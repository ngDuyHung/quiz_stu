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
                    <tr class="hover:bg-primary/5 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center">
                                <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 font-bold flex items-center justify-center text-sm">🥇</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?u=user1" class="w-10 h-10 rounded-full object-cover border-2 border-primary/10" />
                                <div>
                                    <p class="font-bold text-slate-800">Nguyễn Văn A</p>
                                    <p class="text-xs text-slate-400">Kỹ Sư Phần Mềm</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-mono text-slate-600">20240001</td>
                        <td class="px-8 py-6 text-sm text-slate-600">CNTT-01</td>
                        <td class="px-8 py-6 text-right">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-sm">9.2</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-primary/5 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center">
                                <span class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold flex items-center justify-center text-sm">🥈</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?u=user2" class="w-10 h-10 rounded-full object-cover border-2 border-primary/10" />
                                <div>
                                    <p class="font-bold text-slate-800">Trần Thị B</p>
                                    <p class="text-xs text-slate-400">Web Developer</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-mono text-slate-600">20240002</td>
                        <td class="px-8 py-6 text-sm text-slate-600">CNTT-01</td>
                        <td class="px-8 py-6 text-right">
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-bold text-sm">8.9</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-primary/5 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center">
                                <span class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 font-bold flex items-center justify-center text-sm">🥉</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?u=user3" class="w-10 h-10 rounded-full object-cover border-2 border-primary/10" />
                                <div>
                                    <p class="font-bold text-slate-800">Lê Văn C</p>
                                    <p class="text-xs text-slate-400">Data Scientist</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-mono text-slate-600">20240003</td>
                        <td class="px-8 py-6 text-sm text-slate-600">CNTT-02</td>
                        <td class="px-8 py-6 text-right">
                            <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 font-bold text-sm">8.7</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-primary/5 transition-colors bg-primary/5">
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center">
                                <span class="w-8 h-8 rounded-full bg-primary text-white font-bold flex items-center justify-center text-sm">4</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?u=alex" class="w-10 h-10 rounded-full object-cover border-2 border-primary" />
                                <div>
                                    <p class="font-bold text-primary">ALEX NGUYEN (Bạn)</p>
                                    <p class="text-xs text-slate-400">Full Stack Dev</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-mono text-slate-600">20240001</td>
                        <td class="px-8 py-6 text-sm text-slate-600">CNTT-01</td>
                        <td class="px-8 py-6 text-right">
                            <span class="px-3 py-1 rounded-full bg-primary text-white font-bold text-sm">8.8</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-primary/5 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center">
                                <span class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-sm">5</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <img src="https://i.pravatar.cc/150?u=user5" class="w-10 h-10 rounded-full object-cover border-2 border-primary/10" />
                                <div>
                                    <p class="font-bold text-slate-800">Phạm Hoàng D</p>
                                    <p class="text-xs text-slate-400">Mobile Dev</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-mono text-slate-600">20240005</td>
                        <td class="px-8 py-6 text-sm text-slate-600">CNTT-02</td>
                        <td class="px-8 py-6 text-right">
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-bold text-sm">8.5</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-200 p-8 rounded-[2rem] shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Điểm TB Cao Nhất</p>
                    <span class="material-symbols-outlined text-primary text-2xl">trending_up</span>
                </div>
                <p class="text-3xl font-bold text-primary">9.2</p>
                <p class="text-xs text-slate-500 mt-2">Nguyễn Văn A</p>
            </div>

            <div class="bg-white border border-slate-200 p-8 rounded-[2rem] shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Điểm TB Trung Bình</p>
                    <span class="material-symbols-outlined text-secondary text-2xl">bar_chart</span>
                </div>
                <p class="text-3xl font-bold text-secondary">8.7</p>
                <p class="text-xs text-slate-500 mt-2">Toàn khối CNTT</p>
            </div>

            <div class="bg-white border border-slate-200 p-8 rounded-[2rem] shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Vị Trí Của Bạn</p>
                    <span class="material-symbols-outlined text-primary text-2xl">emoji_events</span>
                </div>
                <p class="text-3xl font-bold text-primary">4/150</p>
                <p class="text-xs text-slate-500 mt-2">Top 3% sinh viên</p>
            </div>
        </div>
    </div>
@endsection
