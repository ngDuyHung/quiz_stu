<header class="w-full sticky top-0 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl shadow-sm shadow-blue-900/5 flex items-center justify-between px-8 py-4">
    <div class="flex items-center gap-8 flex-1">
        <span class="lg:hidden text-xl font-bold bg-gradient-to-r from-blue-900 to-indigo-800 bg-clip-text text-transparent font-manrope">
            Axiom Admin
        </span>
        
        <div class="relative hidden md:block w-96">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input class="w-full pl-10 pr-4 py-2.5 bg-slate-100/50 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary-container/20 transition-all" 
                   placeholder="Search Academic Records..." type="text"/>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors relative">
            <span class="material-symbols-outlined">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
        </button>

        <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>

        <div class="flex items-center gap-3 pl-2 cursor-pointer group">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold text-blue-900 leading-none">{{ Auth::user()->name ?? 'Admin Alex' }}</p>
                <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Principal Office</p>
            </div>
            <img alt="Profile" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover" 
                 src="https://ui-avatars.com/api/?name=Admin+Alex&background=1a237e&color=fff"/>
        </div>
    </div>
</header>