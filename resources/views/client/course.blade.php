<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Academic Catalogue - Scholastic Atelier</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@600;700;800&amp;display=swap" rel="stylesheet" />
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

        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(24px);
        }

        .ghost-border {
            outline: 1px solid rgba(195, 198, 209, 0.15);
        }
    </style>
</head>

<body class="bg-surface text-on-surface flex min-h-screen">
    <!-- SideNavBar (Shared Component) -->
    <aside class="flex flex-col fixed left-0 top-0 h-full overflow-y-auto h-screen w-64 border-r-0 bg-slate-50 dark:bg-slate-900 z-50">
        <div class="p-8 flex flex-col gap-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">school</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-[#003466] dark:text-white">Scholastic Atelier</h1>
                    <p class="font-['Manrope'] text-xs font-medium tracking-wide text-slate-500 uppercase">Academic Portal</p>
                </div>
            </div>
            <nav class="flex flex-col space-y-1">
                <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="{{ route('client.dashboard') }}">
                    <span class="material-symbols-outlined" data-icon="home">home</span>
                    <span class="font-['Manrope'] text-sm font-medium tracking-wide">Home</span>
                </a>
                <!-- Active Tab: Courses -->
                <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-[#003466] dark:text-[#88C3FF] font-bold border-r-4 border-[#003466] dark:border-[#88C3FF] bg-slate-200/50 dark:bg-slate-800/50 translate-x-1 transition-transform" href="#">
                    <span class="material-symbols-outlined" data-icon="school">school</span>
                    <span class="font-['Manrope'] text-sm font-medium tracking-wide">Courses</span>
                </a>
                <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="assignment_turned_in">assignment_turned_in</span>
                    <span class="font-['Manrope'] text-sm font-medium tracking-wide">Tasks</span>
                </a>
                <a class="flex items-center gap-4 px-4 py-3 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined" data-icon="account_circle">account_circle</span>
                    <span class="font-['Manrope'] text-sm font-medium tracking-wide">Profile</span>
                </a>
            </nav>
        </div>
        <!-- Examination Progress (Contextual Requirement) -->
        <div class="mt-auto p-6 m-4 bg-surface-container-low rounded-xl">
            <h4 class="text-[0.6875rem] font-bold tracking-widest text-outline uppercase mb-4">Current Standing</h4>
            <div class="flex items-end justify-between mb-2">
                <span class="text-2xl font-extrabold text-primary">3.8</span>
                <span class="text-[0.6875rem] text-outline font-semibold mb-1">CUMULATIVE GPA</span>
            </div>
            <div class="w-full bg-surface-container-high h-2 rounded-full mb-2 overflow-hidden">
                <div class="bg-secondary h-full rounded-full" style="width: 33%"></div>
            </div>
            <p class="text-[0.6875rem] text-on-surface-variant font-medium">33% PROGRAM COMPLETE</p>
        </div>
    </aside>
    <!-- Main Content Canvas -->
    <main class="ml-64 flex-1 flex flex-col min-h-screen">
        <!-- TopAppBar (Shared Component) -->
        <header class="fixed top-0 right-0 left-64 h-16 flex justify-between items-center px-8 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl shadow-sm border-b border-slate-200/15 dark:border-slate-800/15">
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/20 transition-all font-['Manrope'] text-base" placeholder="Search theory, engineering disciplines..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex gap-4 items-center">
                    <button class="p-2 text-slate-500 hover:text-[#003466] transition-all">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="p-2 text-slate-500 hover:text-[#003466] transition-all">
                        <span class="material-symbols-outlined">settings</span>
                    </button>
                </div>
                <div class="w-10 h-10 rounded-full overflow-hidden bg-surface-container-high">
                    <img alt="User Portrait" class="w-full h-full object-cover" data-alt="professional portrait of a scholar in a modern academic setting with soft natural window lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAy8-r5OKaqExq8zXOrGzkVmWs729OzKUQIsiZmM8lwVjSacc24g7tuwbr7nzdqPLnJ7V1Qs6S-j9U05YlrXD6UsMenra3j9-rW9x2cxYr3gZu1UREn9_5MnyNqXUGUvTpkVaCfrbCoeYsDgjkpJeiPBmz5E8skDtpUY6WZULkBdUfwnX_fuj859KCrRPkNJWGfpe7NpQyxD0zocERMT7-QzT8Lnf3FtoCOFs6jMG4sRUXh5AwMeJKeZk_yiUGKDk6o8BfWwF_w0m2o" />
                </div>
            </div>
        </header>
        <!-- Catalogue Content -->
        <section class="mt-16 p-10 max-w-7xl mx-auto w-full">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl font-extrabold text-primary tracking-tight mb-2">Academic Catalogue</h2>
                    <p class="text-on-surface-variant font-medium">Curated intellectual pathways for the modern scholar.</p>
                </div>
                <div class="flex gap-3">
                    <button class="flex items-center gap-2 px-4 py-2 bg-surface-container-lowest ghost-border rounded-lg text-sm font-semibold hover:bg-surface-container-low transition-colors">
                        <span class="material-symbols-outlined text-sm">tune</span>
                        Filter
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2 bg-surface-container-lowest ghost-border rounded-lg text-sm font-semibold hover:bg-surface-container-low transition-colors">
                        <span class="material-symbols-outlined text-sm">swap_vert</span>
                        Sort
                    </button>
                </div>
            </div>
            <!-- Course Grid (Bento Style) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Macroeconomic Theory - FEATURED (Lg Card) -->
                <div class="lg:col-span-2 row-span-1 bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm ghost-border flex group">
                    <div class="w-2/5 relative">
                        <img class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700" data-alt="abstract architectural representation of growth and economic structures with deep blue tones and sharp shadows" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA2jOqP6Ge_QfO9ZgIbTYBQx65NM-Rjow3HmCw7Em2Yg0X4qR11SwFE7Wfjp_kFEALZo1bwI3qTW1CqoDyEnwegqVJP8PuYQQYcOreHIjHVNSYxZm0U53ubOXNoagWdh_iJs33FvZKu4oJdKEUT-GyyQy2BSAg0szXBK7wZbBrPXhY_JIN9sgyepKl254RT6XuhLeO9leqvvj1tSJRceSufmvx7IC8r79Kr6qNs33s0vZ79svJD0SRqhWpGdYOuCXOAH8tyv0EPcnkF" />
                        <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                        <div class="absolute top-4 left-4 bg-tertiary text-white px-3 py-1 rounded text-[0.6875rem] font-bold tracking-widest uppercase">Featured</div>
                    </div>
                    <div class="w-3/5 p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="px-2 py-0.5 bg-primary-fixed text-on-primary-fixed-variant rounded text-[0.6875rem] font-bold tracking-tight">Economics Dept</span>
                                <span class="text-outline text-[0.6875rem] font-medium uppercase tracking-wide">90 min</span>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-3 leading-tight">Macroeconomic Theory</h3>
                            <p class="text-on-surface-variant text-sm line-clamp-2 leading-relaxed">Advanced study of global market dynamics, fiscal policy frameworks, and the mathematics of equilibrium.</p>
                            <p class="mt-4 text-xs font-semibold text-secondary flex items-center gap-1">
                                <span class="material-symbols-outlined text-[1rem]">person</span>
                                Dr. Julian Sterling
                            </p>
                        </div>
                        

                            <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-200">
                                <form action="{{ route('client.answer&question') }}" method="GET">
                                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                                        Join Exam
                                    </button>
                                </form>

                                <form action="{{ route('client.result-detail') }}" method="GET">
                                    <button type="submit" class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-200 transition duration-300">
                                        Details
                                    </button>
                                </form>
                            </div>

                        
                    </div>
                </div>
                <!-- Structural Engineering -->
                <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm ghost-border flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img class="w-full h-full object-cover" data-alt="close-up of complex steel structural joinery with architectural blueprints in background, moody blue lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAXGOt58iiD5o1G0gN6e59htbKlhgopZw_Qjo2EPtzyFwq6A3ZagWAKseYhStjgvhUQQloKwV4BigRznOvgr0cFlJeSkxjoQL211j0IGdxvpkkxmQkNL0hDGW4HqPKNllBEp5XrS_WnktxBnN-V9yMkf0zIlDfGFxI9nKBB36gtSj3sA-y_ZEn_QEFI5N7gXliW_d6a6xN7eWORV4XTbNafk7vlUwI_uz4flntcWjcXMJ2YJR11heoJRXbeCJAvJW5mT5g-LxrTbM9G" />
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <span class="text-[0.6875rem] font-bold tracking-widest text-outline uppercase mb-2">Engineering Faculty</span>
                        <h3 class="text-lg font-bold text-primary mb-4">Structural Engineering</h3>
                        <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Fundamental principles of static systems, material stress analysis, and modern load-bearing design.</p>
                        <div class="mt-auto pt-4 flex justify-between items-center">
                            <span class="text-xs font-semibold text-secondary">Prof. Elena Vance</span>
                            <button class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">
                                Details <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Ethics & Philosophy -->
                <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm ghost-border flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img class="w-full h-full object-cover" data-alt="vintage leather bound books and an inkwell on a wooden desk with soft dramatic study lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_AftV8GObbzumhv6U2yOvon4L4FLGTgj34Q5p6ZNtv50YAN7mx755V7YCiCTBZB-cKvO6GEZmYI8zWPsd4A4s0eT2Ccj7FYhxMowIsTmy5zMk4d_FGh5_lxGngysd_O49f0IZR5GzQEsiqRUeWMnalcG6WfrqkLdrYtQDL0WE2LLm8pQSBTY5nbW189ubnmb4ixP5615f57bcJgBAqlG3W_lGjGUHp5M9Tp_34huJl-qXd6R-f-iOCAPWhrYRZc8HGptErlStYsZa" />
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <span class="text-[0.6875rem] font-bold tracking-widest text-outline uppercase mb-2">Humanities</span>
                        <h3 class="text-lg font-bold text-primary mb-4">Ethics &amp; Philosophy</h3>
                        <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Exploration of classical moral frameworks and their application to contemporary technological dilemmas.</p>
                        <div class="mt-auto pt-4 flex justify-between items-center">
                            <span class="text-xs font-semibold text-secondary">Dr. Marcus Aurel</span>
                            <button class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">
                                Details <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Quantitative Analysis -->
                <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm ghost-border flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img class="w-full h-full object-cover" data-alt="minimalistic visualization of complex data patterns with blue and teal glowing lines on a dark background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDANe4E_tQLa0NVVloP3pD4bp3iXArlYiA6S3JeNwY2YO7zHyWvWB1RI5kIak_RmOMccBUoY97Ubb9zBs1RAaCG52YWdXpCR2PymDPCY338s4fZQ46lgZaMzS5ZMquRqUMtHbYXIok0Ek_xOOwYaQa0c3GfRpw1r_sCwz71twXnV4U3bOiEvmV_ownErvRTguCnapw1scakeuB_AddmW50Zvz98M3whGON8rMfGmxpj6_Ys_WyEpHrS8y-Oav1WiN4XwROKldDVsmXO" />
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <span class="text-[0.6875rem] font-bold tracking-widest text-outline uppercase mb-2">Mathematics</span>
                        <h3 class="text-lg font-bold text-primary mb-4">Quantitative Analysis</h3>
                        <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Rigorous statistical modeling techniques for predictive analytics and high-level problem solving.</p>
                        <div class="mt-auto pt-4 flex justify-between items-center">
                            <span class="text-xs font-semibold text-secondary">Prof. Sarah Chen</span>
                            <button class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">
                                Details <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Organic Chemistry -->
                <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm ghost-border flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img class="w-full h-full object-cover" data-alt="glass laboratory beakers with vibrant blue and amber liquids in a clean modern science facility" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuRGyzFE1NVxF4rTwPHwTJTwR8Os-MpWbaYk2Gc2ShrfnK_5HVjtB-uve88emU6nmmjFIbBTscZFJEVorjUoUzbh9VwN7DGw5zqG8F4PSWWWuLkxhCCAPnqwYv34hrc-IObRm82zkPCHNNzgXXWsJfuz46EJGzb4Z0_MIN-WGzhTid5JHlB_upe6WlQcobg_tw-1dL_wnUU8u11kClupqBqZ1pBFlrM9fofzAgZ00EmMbIUJYgUznJ44zdL8JyZl68BHvM7jb9wKbL" />
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <span class="text-[0.6875rem] font-bold tracking-widest text-outline uppercase mb-2">Natural Sciences</span>
                        <h3 class="text-lg font-bold text-primary mb-4">Organic Chemistry</h3>
                        <p class="text-xs text-on-surface-variant mb-6 leading-relaxed">Synthesis, reaction mechanisms, and the molecular architecture of carbon-based compounds.</p>
                        <div class="mt-auto pt-4 flex justify-between items-center">
                            <span class="text-xs font-semibold text-secondary">Dr. Simon Petro</span>
                            <button class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">
                                Details <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer Section (Examination Progress Alternate) -->
        <footer class="mt-auto px-10 py-6 bg-white border-t border-surface-container-high flex justify-between items-center">
            <div class="flex items-center gap-8">
                <div class="flex flex-col">
                    <span class="text-[0.6875rem] font-bold tracking-widest text-outline uppercase">Active Exams</span>
                    <span class="text-sm font-bold text-primary">2 Pending</span>
                </div>
                <div class="h-8 w-px bg-surface-container-high"></div>
                <div class="flex flex-col">
                    <span class="text-[0.6875rem] font-bold tracking-widest text-outline uppercase">Next Deadline</span>
                    <span class="text-sm font-bold text-error">Tomorrow, 10:00 AM</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <p class="text-xs text-on-surface-variant font-medium">Academic Portal v2.4.0</p>
                <div class="flex gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-[0.6875rem] font-bold text-outline">SYSTEM ONLINE</span>
                </div>
            </div>
        </footer>
    </main>
</body>

</html>