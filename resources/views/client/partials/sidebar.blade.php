<nav class="flex flex-col fixed left-0 top-0 h-full w-64 border-r border-slate-200/50 bg-white dark:bg-slate-900 z-50">
    <div class="p-8 pb-10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white shadow-lg">
                <span class="material-symbols-outlined">school</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-primary dark:text-white leading-tight">Quiz - STU</h1>
                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Portal Sinh Viên</p>
            </div>
        </div>
    </div>

    <div class="flex-1 px-4 space-y-2">
        <a class="nav-item group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all relative overflow-hidden {{ request()->routeIs('client.dashboard') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}" href="{{ route('client.dashboard') }}">
            @if(request()->routeIs('client.dashboard'))
            <div class="absolute inset-0 bg-gradient-to-r from-primary/15 via-primary/10 to-primary/5 rounded-2xl"></div>
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
            @else
            <div class="absolute inset-0 bg-primary/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            @endif
            <span class="material-symbols-outlined relative z-10 @if(request()->routeIs('client.dashboard')) scale-110 @endif group-hover:scale-110 transition-transform" @if(request()->routeIs('client.dashboard')) style="font-variation-settings: 'FILL' 1" @endif>home</span>
            <span class="text-sm font-medium tracking-wide relative z-10 @if(request()->routeIs('client.dashboard')) font-bold @endif">Trang chủ</span>
        </a>
        <a class="nav-item group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all relative overflow-hidden {{ request()->routeIs('client.exams') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}" href="{{ route('client.exams') }}">
            @if(request()->routeIs('client.exams'))
            <div class="absolute inset-0 bg-gradient-to-r from-primary/15 via-primary/10 to-primary/5 rounded-2xl"></div>
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
            @else
            <div class="absolute inset-0 bg-primary/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            @endif
            <span class="material-symbols-outlined relative z-10 @if(request()->routeIs('client.exams')) scale-110 @endif group-hover:scale-110 transition-transform" @if(request()->routeIs('client.exams')) style="font-variation-settings: 'FILL' 1" @endif>assignment_turned_in</span>
            <span class="text-sm font-medium tracking-wide relative z-10 @if(request()->routeIs('client.exams')) font-bold @endif">Kỳ thi</span>
        </a>
        <a class="nav-item group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all relative overflow-hidden {{ request()->routeIs('client.courses') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}" href="{{ route('client.courses') }}">
            @if(request()->routeIs('client.courses'))
            <div class="absolute inset-0 bg-gradient-to-r from-primary/15 via-primary/10 to-primary/5 rounded-2xl"></div>
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
            @else
            <div class="absolute inset-0 bg-primary/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            @endif
            <span class="material-symbols-outlined relative z-10 @if(request()->routeIs('client.courses')) scale-110 @endif group-hover:scale-110 transition-transform" @if(request()->routeIs('client.courses')) style="font-variation-settings: 'FILL' 1" @endif>auto_stories</span>
            <span class="text-sm font-medium tracking-wide relative z-10 @if(request()->routeIs('client.courses')) font-bold @endif">Khóa học</span>
        </a>
        <a class="nav-item group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all relative overflow-hidden {{ request()->routeIs('client.history') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}" href="{{ route('client.history') }}">
            @if(request()->routeIs('client.history'))
            <div class="absolute inset-0 bg-gradient-to-r from-primary/15 via-primary/10 to-primary/5 rounded-2xl"></div>
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
            @else
            <div class="absolute inset-0 bg-primary/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            @endif
            <span class="material-symbols-outlined relative z-10 @if(request()->routeIs('client.history')) scale-110 @endif group-hover:scale-110 transition-transform" @if(request()->routeIs('client.history')) style="font-variation-settings: 'FILL' 1" @endif>history</span>
            <span class="text-sm font-medium tracking-wide relative z-10 @if(request()->routeIs('client.history')) font-bold @endif">Lịch sử thi</span>
        </a>
        <a class="nav-item group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all relative overflow-hidden {{ request()->routeIs('client.ranking') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}" href="{{ route('client.ranking') }}">
            @if(request()->routeIs('client.ranking'))
            <div class="absolute inset-0 bg-gradient-to-r from-primary/15 via-primary/10 to-primary/5 rounded-2xl"></div>
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
            @else
            <div class="absolute inset-0 bg-primary/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            @endif
            <span class="material-symbols-outlined relative z-10 @if(request()->routeIs('client.ranking')) scale-110 @endif group-hover:scale-110 transition-transform" @if(request()->routeIs('client.ranking')) style="font-variation-settings: 'FILL' 1" @endif>leaderboard</span>
            <span class="text-sm font-medium tracking-wide relative z-10 @if(request()->routeIs('client.ranking')) font-bold @endif">Bảng điểm</span>
        </a>
    </div>

        <a class="nav-item group flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all relative overflow-hidden {{ request()->routeIs('client.profile') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}" href="{{ route('client.profile') }}">
            @if(request()->routeIs('client.profile'))
            <div class="absolute inset-0 bg-gradient-to-r from-primary/15 via-primary/10 to-primary/5 rounded-2xl"></div>
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/10 rounded-full blur-2xl"></div>
            @else
            <div class="absolute inset-0 bg-primary/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
            @endif
            <span class="material-symbols-outlined relative z-10 @if(request()->routeIs('client.profile')) scale-110 @endif group-hover:scale-110 transition-transform" @if(request()->routeIs('client.profile')) style="font-variation-settings: 'FILL' 1" @endif>manage_accounts</span>
            <span class="text-sm font-medium tracking-wide relative z-10 @if(request()->routeIs('client.profile')) font-bold @endif">Hồ sơ</span>
        </a>
    </div>

    <div class="p-6 mt-auto">
        <div class="bg-primary-container rounded-2xl p-5 text-white relative overflow-hidden group">
            <div class="relative z-10">
                <button id="logout-trigger" class="flex items-center w-full gap-3 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl border border-white/20 transition-all">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-bold">Đăng xuất</span>
                </button>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 opacity-10 text-6xl">account_circle</span>
        </div>
    </div>
</nav>