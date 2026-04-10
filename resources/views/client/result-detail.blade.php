<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Scholastic Atelier - Assessment Results</title>
<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@500;700;800&amp;display=swap" rel="stylesheet"/>
<!-- Material Icons -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
<!-- Shared SideNavBar -->
<aside class="flex flex-col fixed left-0 top-0 h-full overflow-y-auto h-screen w-64 border-r-0 bg-slate-50 dark:bg-slate-900 z-50">
<div class="px-6 py-8">
<div class="flex items-center gap-3 mb-10">
<div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white">
<span class="material-symbols-outlined" data-icon="school">school</span>
</div>
<div>
<h1 class="text-xl font-bold text-[#003466] dark:text-white leading-none">Scholastic Atelier</h1>
<p class="text-xs text-slate-500 font-medium mt-1">Academic Portal</p>
</div>
</div>
<nav class="space-y-1">
<a class="flex items-center gap-3 px-4 py-3 font-['Manrope'] text-sm font-medium tracking-wide text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="{{ route('client.dashboard') }}">
<span class="material-symbols-outlined" data-icon="home">home</span>
<span>Home</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 font-['Manrope'] text-sm font-bold tracking-wide text-[#003466] dark:text-[#88C3FF] border-r-4 border-[#003466] dark:border-[#88C3FF] bg-slate-200/50 dark:bg-slate-800/50 translate-x-1 transition-transform" href="#">
<span class="material-symbols-outlined" data-icon="school">school</span>
<span>Courses</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 font-['Manrope'] text-sm font-medium tracking-wide text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="assignment_turned_in">assignment_turned_in</span>
<span>Tasks</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 font-['Manrope'] text-sm font-medium tracking-wide text-slate-600 dark:text-slate-400 hover:text-[#1A4B84] hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="account_circle">account_circle</span>
<span>Profile</span>
</a>
</nav>
</div>
</aside>
<!-- Shared TopAppBar -->
<header class="fixed top-0 right-0 left-64 h-16 flex justify-between items-center px-8 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl shadow-sm border-b border-slate-200/15 dark:border-slate-800/15">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg" data-icon="search">search</span>
<input class="w-full pl-10 pr-4 py-1.5 bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-[#1A4B84]/20 transition-all" placeholder="Search academic resources..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-4">
<button class="text-slate-500 hover:text-[#003466] transition-all">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="text-slate-500 hover:text-[#003466] transition-all">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</button>
</div>
<div class="flex items-center gap-3 border-l border-slate-200 pl-6">
<div class="text-right">
<p class="text-sm font-semibold text-primary leading-none">Prof. Sterling</p>
<p class="text-[10px] text-slate-500 uppercase tracking-wider mt-1">Lead Academic</p>
</div>
<img alt="User Portrait" class="w-8 h-8 rounded-full object-cover border border-slate-200" data-alt="Close-up portrait of a professional academic man with spectacles in a bright studio setting, high-end editorial style" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDIlTp-9yBM7g_ZRCr3T47eCkgJ5H37Htc8wQipBOW5u3atLFaevHEwNRENq9wCiQzOLyQ8wpaRMAfAPMKJAXS3wzm2BLXKQaOMZ976OUVWdMjwYubnlQ7k0wfbn-21teys7QmhTGD9xYeUSk2UBBTe03k00r1qEvUIW6y1bK1MiU9hbIAG4SKCO25Y_7axsWKZq-U9OgRHmaJIsnXuUXH6fcC_zkmvqq2Ic-HoT8YJRewY_AtzuBjGiq9OAG5payqdTtRhIwMLgwS5"/>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="ml-64 pt-16 min-h-screen">
<div class="max-w-7xl mx-auto px-8 py-12">
<!-- Hero Results Section -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12 items-end">
<div class="lg:col-span-7">
<nav class="flex items-center gap-2 text-sm font-medium text-secondary mb-4">
<span>Courses</span>
<span class="material-symbols-outlined text-xs" data-icon="chevron_right">chevron_right</span>
<span>Theoretical Physics</span>
<span class="material-symbols-outlined text-xs" data-icon="chevron_right">chevron_right</span>
<span class="text-on-surface-variant">Assessment Results</span>
</nav>
<h2 class="text-5xl font-extrabold text-primary mb-4 tracking-tight leading-tight">Exceptional Work!</h2>
<p class="text-lg text-on-surface-variant max-w-xl leading-relaxed">Your performance in the Advanced Quantum Mechanics module places you in the top 5% of the current cohort. Your grasp of wave-particle duality is remarkable.</p>
</div>
<div class="lg:col-span-5 flex justify-end">
<!-- Circular Score Widget -->
<div class="relative w-64 h-64 flex items-center justify-center bg-surface-container-lowest rounded-full shadow-Ambient">
<svg class="w-56 h-56 transform -rotate-90">
<circle class="text-surface-container-high" cx="112" cy="112" fill="transparent" r="104" stroke="currentColor" stroke-width="12"></circle>
<circle class="text-secondary" cx="112" cy="112" fill="transparent" r="104" stroke="currentColor" stroke-dasharray="653" stroke-dashoffset="65" stroke-linecap="round" stroke-width="12"></circle>
</svg>
<div class="absolute flex flex-col items-center">
<span class="text-6xl font-extrabold text-primary tracking-tighter">90</span>
<span class="text-sm font-bold text-slate-400 tracking-widest uppercase -mt-2">/ 100</span>
</div>
</div>
</div>
</section>
<!-- Metrics Bento Grid -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
<!-- Time Proficiency -->
<div class="bg-primary text-white p-8 rounded-xl flex flex-col justify-between shadow-lg relative overflow-hidden group">
<div class="z-10">
<span class="material-symbols-outlined text-secondary-container text-4xl mb-6" data-icon="avg_pace">avg_pace</span>
<h3 class="text-label-sm font-bold tracking-widest uppercase opacity-70 mb-2">Time Proficiency</h3>
<p class="text-4xl font-bold font-headline">18:42</p>
<p class="text-sm mt-2 font-medium text-secondary-container">12 mins faster than average</p>
</div>
<div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-[160px]" data-icon="timer">timer</span>
</div>
</div>
<!-- Topic Breakdown -->
<div class="md:col-span-2 bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/15">
<h3 class="text-xl font-bold text-primary mb-8">Conceptual Mastery Breakdown</h3>
<div class="space-y-8">
<div class="space-y-3">
<div class="flex justify-between items-end">
<span class="text-sm font-semibold text-on-surface">Macro Dynamics</span>
<span class="text-sm font-bold text-secondary">85%</span>
</div>
<div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-primary-container rounded-full" style="width: 85%"></div>
</div>
</div>
<div class="space-y-3">
<div class="flex justify-between items-end">
<span class="text-sm font-semibold text-on-surface">Quantum Principles</span>
<span class="text-sm font-bold text-secondary">98%</span>
</div>
<div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-secondary rounded-full" style="width: 98%"></div>
</div>
</div>
<div class="space-y-3">
<div class="flex justify-between items-end">
<span class="text-sm font-semibold text-on-surface">Ethical Implications</span>
<span class="text-sm font-bold text-tertiary">72%</span>
</div>
<div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-tertiary-container rounded-full" style="width: 72%"></div>
</div>
</div>
</div>
</div>
</section>
<!-- Detailed Response Analysis -->
<section class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/15 overflow-hidden">
<div class="px-8 py-6 bg-surface-container-low border-b border-outline-variant/10 flex justify-between items-center">
<h3 class="text-xl font-bold text-primary">Response Detail Analysis</h3>
<div class="flex gap-2">
<span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase tracking-tighter">18 Correct</span>
<span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-full uppercase tracking-tighter">2 Incorrect</span>
</div>
</div>
<div class="divide-y divide-outline-variant/10">
<!-- Correct Response -->
<div class="p-8 hover:bg-surface-container-low/50 transition-colors">
<div class="flex gap-6">
<div class="flex-shrink-0 mt-1">
<span class="material-symbols-outlined text-green-600 bg-green-50 p-2 rounded-lg" data-icon="check_circle">check_circle</span>
</div>
<div class="flex-1">
<div class="flex justify-between mb-2">
<h4 class="font-bold text-lg text-primary">Quantum Superposition (Heisenberg)</h4>
<span class="text-xs font-medium text-slate-400">Question 04</span>
</div>
<p class="text-on-surface-variant text-sm leading-relaxed mb-4">Identify the physicist who formulated the uncertainty principle stating that the position and momentum of a particle cannot both be precisely known.</p>
<div class="bg-surface p-4 rounded-lg border-l-4 border-green-500">
<p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Detailed Feedback</p>
<p class="text-sm text-on-surface">Your selection of Werner Heisenberg is correct. This foundational principle in quantum mechanics highlights the limits of classical intuition. Excellent citation of the 1927 paper in your supplementary notes.</p>
</div>
</div>
</div>
</div>
<!-- Incorrect Response -->
<div class="p-8 hover:bg-surface-container-low/50 transition-colors">
<div class="flex gap-6">
<div class="flex-shrink-0 mt-1">
<span class="material-symbols-outlined text-error bg-error-container/20 p-2 rounded-lg" data-icon="cancel">cancel</span>
</div>
<div class="flex-1">
<div class="flex justify-between mb-2">
<h4 class="font-bold text-lg text-primary">Statistical Thermodynamics</h4>
<span class="text-xs font-medium text-slate-400">Question 09</span>
</div>
<p class="text-on-surface-variant text-sm leading-relaxed mb-4">Calculate the entropy change for an ideal gas expansion under the Boltzmann H-theorem.</p>
<div class="bg-surface p-4 rounded-lg border-l-4 border-error">
<p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Detailed Feedback</p>
<p class="text-sm text-on-surface mb-2">You selected a value of 0.45J/K, which reflects a misunderstanding of the molar constant application. The correct methodology requires integrating the differential probability density across the full phase space.</p>
<a class="text-xs font-bold text-secondary hover:underline flex items-center gap-1" href="#">
                                        Review "Boltzmann Distributions" Lecture Notes
                                        <span class="material-symbols-outlined text-[10px]" data-icon="arrow_outward">arrow_outward</span>
</a>
</div>
</div>
</div>
</div>
<!-- Correct Response -->
<div class="p-8 hover:bg-surface-container-low/50 transition-colors">
<div class="flex gap-6">
<div class="flex-shrink-0 mt-1">
<span class="material-symbols-outlined text-green-600 bg-green-50 p-2 rounded-lg" data-icon="check_circle">check_circle</span>
</div>
<div class="flex-1">
<div class="flex justify-between mb-2">
<h4 class="font-bold text-lg text-primary">Wave-Equation Formalism (Schrodinger)</h4>
<span class="text-xs font-medium text-slate-400">Question 14</span>
</div>
<p class="text-on-surface-variant text-sm leading-relaxed mb-4">Define the primary application of the time-independent wave equation in a three-dimensional potential well.</p>
<div class="bg-surface p-4 rounded-lg border-l-4 border-green-500">
<p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Detailed Feedback</p>
<p class="text-sm text-on-surface">Perfect application of Erwin Schrodinger's methodology. Your explanation of the wave function collapse during observation shows a mature understanding of the Copenhagen interpretation.</p>
</div>
</div>
</div>
</div>
</div>
<!-- Action Footer -->
<div class="p-8 bg-surface-container-high/30 flex justify-end gap-4">
<button class="px-6 py-2.5 rounded-lg font-bold text-primary border border-primary/20 hover:bg-white transition-all text-sm">Download PDF Certificate</button>
<button class="px-8 py-2.5 rounded-lg font-bold bg-primary text-white shadow-md hover:shadow-lg transition-all text-sm">Proceed to Next Module</button>
</div>
</section>
</div>
</main>
</body></html>