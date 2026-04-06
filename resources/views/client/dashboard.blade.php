<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quiz - STU</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Manrope:wght@500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "secondary-container": "#88c3ff",
                        "on-error": "#ffffff",
                        "surface-tint": "#335f99",
                        "primary-fixed": "#d5e3ff",
                        "outline-variant": "#c3c6d1",
                        "surface-container-low": "#f2f4f6",
                        "on-tertiary-container": "#f7a967",
                        "on-secondary-fixed-variant": "#004a79",
                        "primary-fixed-dim": "#a6c8ff",
                        "primary-container": "#1a4b84",
                        "on-primary": "#ffffff",
                        "error": "#ba1a1a",
                        "primary": "#003466",
                        "tertiary-container": "#733c00",
                        "background": "#f7f9fb",
                        "on-primary-fixed-variant": "#144780",
                        "secondary": "#1a6299",
                        "on-surface-variant": "#424750",
                        "on-primary-fixed": "#001c3b",
                        "surface-variant": "#e0e3e5",
                        "on-background": "#191c1e",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed": "#2f1500",
                        "on-secondary-fixed": "#001d34",
                        "on-error-container": "#93000a",
                        "tertiary-fixed": "#ffdcc3",
                        "surface": "#f7f9fb",
                        "inverse-primary": "#a6c8ff",
                        "surface-bright": "#f7f9fb",
                        "tertiary": "#522900",
                        "tertiary-fixed-dim": "#ffb77d",
                        "surface-container-highest": "#e0e3e5",
                        "secondary-fixed": "#cfe5ff",
                        "on-secondary-container": "#005082",
                        "on-tertiary-fixed-variant": "#6e3900",
                        "on-surface": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "surface-dim": "#d8dadc",
                        "inverse-surface": "#2d3133",
                        "outline": "#737781",
                        "surface-container-high": "#e6e8ea",
                        "secondary-fixed-dim": "#9acbff",
                        "on-primary-container": "#93bcfc",
                        "surface-container": "#eceef0",
                        "on-tertiary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Manrope', sans-serif;
        }
    </style>
</head>

<body class="bg-surface text-on-background min-h-screen">
    <!-- SideNavBar (Execution from JSON) -->
    <nav class="flex flex-col fixed left-0 top-0 h-full overflow-y-auto h-screen w-64 border-r-0 bg-slate-50 dark:bg-slate-900 z-50">
        <div class="p-8 pb-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white shadow-lg">
                    <span class="material-symbols-outlined" data-icon="school">school</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-[#003466] dark:text-white leading-tight">Quiz - STU</h1>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Web thi trắc nghiệm</p>
                </div>
            </div>
        </div>
        <div class="flex-1 px-4 space-y-1">
            <!-- Active: Home -->
            <a class="flex items-center gap-4 px-4 py-3 rounded-xl text-[#003466] dark:text-[#88C3FF] font-bold border-r-4 border-[#003466] dark:border-[#88C3FF] bg-slate-200/50 dark:bg-slate-800/50 translate-x-1 transition-transform" href="#">
                <span class="material-symbols-outlined" data-icon="home" style="font-variation-settings: 'FILL' 1;">home</span>
                <span class="font-['Manrope'] text-sm font-medium tracking-wide">Home</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200"
                href="{{ route('client.course') }}">
                <span class="material-symbols-outlined">school</span>
                <span class="font-['Manrope'] text-sm font-medium tracking-wide">Courses</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
                <span class="material-symbols-outlined" data-icon="assignment_turned_in">assignment_turned_in</span>
                <span class="font-['Manrope'] text-sm font-medium tracking-wide">Tasks</span>
            </a>
            <a class="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
                <span class="material-symbols-outlined" data-icon="account_circle">account_circle</span><span class="font-['Manrope'] text-sm font-medium tracking-wide">Profile</span>
            </a>
        </div>
        <div class="p-6 mt-auto">
    <div class="bg-primary-container rounded-2xl p-5 text-white/90 relative overflow-hidden group">
        <div class="logout-section relative z-10">
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full gap-3 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl border border-white/20 transition-all duration-200">
                    <span class="material-symbols-outlined text-white">logout</span>
                    <span class="font-['Manrope'] text-sm font-bold text-white tracking-wide">Đăng xuất</span>
                </button>
            </form>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <span class="material-symbols-outlined text-6xl">auto_stories</span>
        </div>
    </div>
</div>
    </nav>
    <!-- TopAppBar (Execution from JSON) -->
    <header class="fixed top-0 right-0 left-64 h-16 flex justify-between items-center px-8 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl shadow-sm border-b border-slate-200/15 dark:border-slate-800/15">
        <div class="flex items-center flex-1 max-w-xl">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl" data-icon="search">search</span>
                <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-11 pr-4 text-sm focus:ring-2 focus:ring-[#1A4B84]/20 transition-all" placeholder="Search curriculum, faculty, or archives..." type="text" />
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:text-[#003466] hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:text-[#003466] hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined" data-icon="settings">settings</span>
                </button>
            </div>
            <div class="h-8 w-[1px] bg-slate-200"></div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-semibold text-primary">USER</span>
                <img alt="User Portrait" class="w-10 h-10 rounded-full object-cover border-2 border-primary/10" data-alt="Close-up portrait of a young male student with glasses in a library setting, soft natural lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA-mybWv1RiZfCiKD5lSbSxn0mJOBi4dtI4mdhexukcLMJPsMmA03bpzV6i-t9JLSJkmR2Mx5vd5EcuTeHtCdg63UEChJgJDekklgieKZfdJ2y6nkVKyl11SipOh9d6Qp7-_Q2bMyHSD9XXQmAP43OIRp2NbaTd4JHTJPIQL88kspJ1sMhOg2B8UJjnx1PZTG9gfM8zHaOcYan4FsV_YyK5h1e5nQySpFB5y7S_t5lMS3YyZdmLHhSTgX1cTmrstYDPT9DqBcifkBpA" />
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="ml-64 pt-24 px-8 pb-12">
        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Hero Announcement Section -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                <div class="lg:col-span-8">
                    <span class="text-[11px] font-bold tracking-[0.2em] text-secondary uppercase mb-3 block">Dashboard Overview</span>
                    <h1 class="text-5xl font-extrabold text-primary tracking-tight mb-4">Hello Alex,</h1>
                    <p class="text-lg text-on-surface-variant max-w-2xl leading-relaxed">
                        Your academic journey is <span class="text-primary font-bold">85% complete</span>. You are maintaining an exceptional trajectory in the Theoretical Sciences track.
                    </p>
                </div>
                <div class="lg:col-span-4">
                    <div class="bg-surface-container-low p-4 rounded-2xl flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-tertiary/10 flex items-center justify-center text-tertiary">
                            <span class="material-symbols-outlined" data-icon="campaign">campaign</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-tertiary uppercase tracking-wider">System Announcement</p>
                            <p class="text-sm font-semibold text-on-surface">Advanced Theoretical Physics exam schedule updated</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bento Grid Content -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Progress Circular Section -->
                <div class="lg:col-span-4 bg-surface-container-lowest rounded-[2rem] p-8 shadow-sm relative overflow-hidden group">
                    <div class="relative z-10 h-ful