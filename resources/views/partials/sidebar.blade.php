<aside class="hidden lg:flex flex-col h-screen sticky top-0 left-0 w-64 bg-slate-50 p-6 border-r border-slate-200 font-manrope">
    <div class="flex items-center gap-3 mb-10">
        <div class="w-10 h-10 bg-primary-container rounded-xl flex items-center justify-center text-white">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">school</span>
        </div>
        <div>
            <h1 class="text-lg font-extrabold text-primary leading-tight">Academic</h1>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Portal</p>
        </div>
    </div>

    <nav class="flex-grow space-y-1">
        @php
            $menus = [
                ['route' => 'admin.dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
                ['route' => 'admin.faculties.*', 'icon' => 'auto_stories', 'label' => 'Faculties'],
                ['route' => 'admin.users.*', 'icon' => 'group', 'label' => 'Users'],
                ['route' => 'admin.questions.*', 'icon' => 'science', 'label' => 'Research'],
                ['route' => 'admin.results.*', 'icon' => 'monitoring', 'label' => 'Analytics'],
            ];
        @endphp

        @foreach($menus as $menu)
            @php
                $baseRoute = str_replace('.*', '.index', $menu['route']);
                $isActive = request()->routeIs($menu['route']);
            @endphp
            <a href="{{ Route::has($baseRoute) ? route($baseRoute) : '#' }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all active:scale-95 
               {{ $isActive ? 'bg-blue-100/50 text-blue-900 shadow-sm' : 'text-slate-600 hover:bg-white hover:shadow-sm' }}">
                <span class="material-symbols-outlined" style="{{ $isActive ? "font-variation-settings: 'FILL' 1;" : "" }}">
                    {{ $menu['icon'] }}
                </span>
                <span class="{{ $isActive ? 'font-bold' : '' }} text-sm">{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-auto pt-6">
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 text-error px-4 py-3 hover:bg-error-container/20 transition-all rounded-xl active:scale-95 text-sm font-bold">
                <span class="material-symbols-outlined">logout</span>
                Logout
            </button>
        </form>
    </div>
</aside>