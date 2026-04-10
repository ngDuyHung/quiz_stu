<header class="fixed top-0 right-0 left-64 h-16 flex justify-between items-center px-8 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-200/50">
        <div class="flex items-center flex-1 max-w-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                <input class="w-full bg-slate-100 border-none rounded-full py-2 pl-11 pr-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Tìm kiếm môn học, bài thi..." type="text" />
            </div>
        </div>

        @php $authUser = auth()->user(); @endphp
        <a href="{{ route('client.profile') }}" class="flex items-center gap-4 ml-6 group">
            <div class="text-right">
                <p class="text-sm font-bold text-primary group-hover:text-secondary transition-colors">
                    {{ strtoupper($authUser->last_name . ' ' . $authUser->first_name) }}
                </p>
                <p class="text-[10px] text-slate-500 font-mono">
                    {{ $authUser->student_code ? 'MSSV: ' . $authUser->student_code : $authUser->email }}
                </p>
            </div>
            @if($authUser->photo && file_exists(public_path('storage/' . $authUser->photo)))
                <img src="{{ asset('storage/' . $authUser->photo) }}"
                     class="w-10 h-10 rounded-full border-2 border-primary/10 object-cover" alt="Avatar">
            @else
                <div class="w-10 h-10 rounded-full border-2 border-primary/10 bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-xl">person</span>
                </div>
            @endif
        </a>
    </header>