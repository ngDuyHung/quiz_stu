<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Scholastic Atelier - Advanced Macroeconomics Exam</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@300;400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
<body class="bg-surface text-on-background selection:bg-secondary-container selection:text-on-secondary-container">
<!-- TopAppBar Integration -->
<header class="fixed top-0 right-0 left-0 h-16 flex justify-between items-center px-8 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl shadow-sm border-b border-slate-200/15 dark:border-slate-800/15">
<div class="flex items-center gap-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">school</span>
</div>
<span class="font-headline font-extrabold text-primary tracking-tight text-lg">Scholastic Atelier</span>
</div>
<div class="h-6 w-px bg-outline-variant/30"></div>
<span class="font-headline font-semibold text-on-surface-variant uppercase tracking-widest text-[10px]">MACROECONOMICS: ADVANCED THEORY</span>
</div>
<div class="flex items-center gap-8">
<div class="flex flex-col items-end">
<span class="font-label text-[10px] font-bold text-tertiary tracking-widest">TIME REMAINING</span>
<span class="font-headline text-xl font-bold text-primary tracking-tighter">42:15</span>
</div>
<div class="flex items-center gap-4">
<button class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<div class="w-10 h-10 rounded-full bg-surface-container-highest overflow-hidden border-2 border-primary/10">
<img alt="User Portrait" class="w-full h-full object-cover" data-alt="Professional studio portrait of a male student wearing glasses in soft academic lighting against a neutral background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-NfWeG4Y9Ji0EtGJDuCRY-iRdnTU_vTdTYAZDxj9VgBVuZud3_WsDvmDQBzFZx_o_9_6AHjbzTOKVFgLBlbAej9yTgrunkn0fTyef645UVoc4jJi3jra-ALUYpLjZ7N3FMOqPpyo1KzD_AImCHkVxbSAB4MwLo9B5Iqr-YGA9vkSMAfcGeNmCvLdK9gQA5BSBZpeXTKLNuRmtiwcbZkrrmyAXi_O6HUXp_SmGKePrAONGiXjnfwxd-XBDVvUdMiOIJb2UUjv_yr57"/>
</div>
</div>
</div>
</header>
<main class="pt-24 pb-12 px-8 flex gap-8 max-w-[1600px] mx-auto min-h-screen">
<!-- Left Content Area: Question & Options -->
<div class="flex-grow space-y-8">
<div class="flex justify-between items-end">
<div>
<span class="font-label text-xs font-bold text-secondary uppercase tracking-[0.2em] block mb-2">PART II: MONETARY SYSTEMS</span>
<h1 class="font-headline text-4xl font-extrabold text-primary">Question 07</h1>
</div>
<div class="flex gap-2">
<span class="px-4 py-1.5 rounded-full bg-surface-container-high text-on-surface-variant font-label text-[11px] font-bold tracking-wider">SINGLE CHOICE</span>
<span class="px-4 py-1.5 rounded-full bg-primary/5 text-primary font-label text-[11px] font-bold tracking-wider">2.5 POINTS</span>
</div>
</div>
<!-- Question Card -->
<div class="bg-surface-container-lowest rounded-xl p-10 shadow-ambient">
<p class="font-headline text-2xl font-medium leading-relaxed text-on-surface">
                    In the context of the <span class="text-secondary font-bold underline decoration-secondary-container decoration-4 underline-offset-4">Monetary Policy Transmission Mechanism</span>, which sequence best describes the interest rate channel impact following a contractionary open market operation?
                </p>
</div>
<!-- Options Grid -->
<div class="grid grid-cols-1 gap-4">
<!-- Option A (Active/Selected State) -->
<button class="group flex items-start text-left bg-primary-container text-on-primary-container rounded-xl p-6 ring-2 ring-primary ring-offset-4 ring-offset-surface transition-all duration-300">
<span class="w-10 h-10 rounded-lg bg-primary text-white flex items-center justify-center font-headline font-bold mr-6 shrink-0 shadow-lg">A</span>
<span class="font-body text-lg leading-relaxed pt-1.5">Decrease in reserves → Rise in short-term rates → Rise in long-term rates → Fall in investment → Decrease in aggregate demand.</span>
</button>
<!-- Option B -->
<button class="group flex items-start text-left bg-surface-container-lowest text-on-surface hover:bg-surface-container-low rounded-xl p-6 transition-all duration-200">
<span class="w-10 h-10 rounded-lg bg-surface-container-high text-on-surface-variant group-hover:bg-primary/10 group-hover:text-primary flex items-center justify-center font-headline font-bold mr-6 shrink-0 transition-colors">B</span>
<span class="font-body text-lg leading-relaxed pt-1.5">Increase in reserves → Fall in short-term rates → Rise in equity prices → Increase in household wealth → Increase in consumption.</span>
</button>
<!-- Option C -->
<button class="group flex items-start text-left bg-surface-container-lowest text-on-surface hover:bg-surface-container-low rounded-xl p-6 transition-all duration-200">
<span class="w-10 h-10 rounded-lg bg-surface-container-high text-on-surface-variant group-hover:bg-primary/10 group-hover:text-primary flex items-center justify-center font-headline font-bold mr-6 shrink-0 transition-colors">C</span>
<span class="font-body text-lg leading-relaxed pt-1.5">Decrease in reserves → Rise in short-term rates → Currency depreciation → Increase in net exports → Increase in output.</span>
</button>
<!-- Option D -->
<button class="group flex items-start text-left bg-surface-container-lowest text-on-surface hover:bg-surface-container-low rounded-xl p-6 transition-all duration-200">
<span class="w-10 h-10 rounded-lg bg-surface-container-high text-on-surface-variant group-hover:bg-primary/10 group-hover:text-primary flex items-center justify-center font-headline font-bold mr-6 shrink-0 transition-colors">D</span>
<span class="font-body text-lg leading-relaxed pt-1.5">Increase in reserves → Rise in commercial bank lending → Expansion of the money supply → Shift in the LM curve to the right.</span>
</button>
</div>
<!-- Action Bar -->
<div class="flex justify-between items-center pt-8 border-t border-outline-variant/15">
<button class="flex items-center gap-2 font-headline font-bold text-primary hover:translate-x-[-4px] transition-transform">
<span class="material-symbols-outlined">arrow_back</span>
                    Previous Question
                </button>
<div class="flex gap-4">
<button class="px-8 py-3.5 rounded-lg border-2 border-primary/20 text-primary font-headline font-bold hover:bg-primary/5 transition-all">
                        Mark for Review
                    </button>
<button class="px-10 py-3.5 rounded-lg bg-primary text-white font-headline font-bold shadow-lg hover:shadow-xl hover:translate-y-[-2px] transition-all">
                        Next Question
                    </button>
</div>
</div>
</div>
<!-- Right Sidebar: Navigator -->
<aside class="w-80 shrink-0 space-y-6">
<!-- Progress Circle Card -->
<div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
<div class="flex items-center justify-between mb-4">
<h3 class="font-headline font-bold text-primary text-sm uppercase tracking-wider">Exam Progress</h3>
<span class="font-headline font-bold text-secondary text-lg">35%</span>
</div>
<div class="h-2 w-full bg-surface-container-high rounded-full overflow-hidden">
<div class="h-full bg-secondary w-[35%] rounded-full shadow-[0_0_8px_rgba(26,98,153,0.4)]"></div>
</div>
<div class="mt-4 flex justify-between text-[11px] font-label font-bold text-on-surface-variant uppercase tracking-widest">
<span>7 OF 20 QUESTIONS</span>
<span>13 REMAINING</span>
</div>
</div>
<!-- Navigator Grid -->
<div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
<h3 class="font-headline font-bold text-primary text-sm uppercase tracking-wider mb-6">Question Navigator</h3>
<div class="grid grid-cols-5 gap-3">
<!-- Answered -->
<button class="w-10 h-10 rounded-lg bg-primary/10 text-primary font-headline font-bold flex items-center justify-center text-xs">01</button>
<button class="w-10 h-10 rounded-lg bg-primary/10 text-primary font-headline font-bold flex items-center justify-center text-xs">02</button>
<button class="w-10 h-10 rounded-lg bg-primary/10 text-primary font-headline font-bold flex items-center justify-center text-xs">03</button>
<!-- Marked for Review -->
<button class="w-10 h-10 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed font-headline font-bold flex items-center justify-center text-xs relative">
                        04
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-tertiary border-2 border-surface-container-lowest rounded-full"></span>
</button>
<button class="w-10 h-10 rounded-lg bg-primary/10 text-primary font-headline font-bold flex items-center justify-center text-xs">05</button>
<button class="w-10 h-10 rounded-lg bg-primary/10 text-primary font-headline font-bold flex items-center justify-center text-xs">06</button>
<!-- Active -->
<button class="w-10 h-10 rounded-lg bg-primary text-white font-headline font-bold flex items-center justify-center text-xs shadow-md ring-2 ring-offset-2 ring-primary">07</button>
<!-- Unanswered -->
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">08</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">09</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">10</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">11</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">12</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">13</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">14</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">15</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">16</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">17</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">18</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">19</button>
<button class="w-10 h-10 rounded-lg bg-surface-container-low text-on-surface-variant font-headline font-medium flex items-center justify-center text-xs hover:bg-surface-container-high">20</button>
</div>
<div class="mt-8 pt-6 border-t border-outline-variant/15 space-y-3">
<div class="flex items-center gap-3">
<div class="w-3 h-3 rounded-full bg-primary/20"></div>
<span class="font-label text-[10px] font-bold text-on-surface-variant tracking-wider uppercase">Answered</span>
</div>
<div class="flex items-center gap-3">
<div class="w-3 h-3 rounded-full bg-tertiary"></div>
<span class="font-label text-[10px] font-bold text-on-surface-variant tracking-wider uppercase">Marked for Review</span>
</div>
<div class="flex items-center gap-3">
<div class="w-3 h-3 rounded-full bg-surface-container-high"></div>
<span class="font-label text-[10px] font-bold text-on-surface-variant tracking-wider uppercase">Remaining</span>
</div>
</div>
</div>
<!-- Submit Action -->
<button class="w-full py-5 rounded-xl bg-error text-on-error font-headline font-extrabold uppercase tracking-widest text-sm shadow-lg hover:shadow-error/30 hover:translate-y-[-2px] transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-lg">fact_check</span>
                Submit Final Exam
            </button>
<!-- Need Help -->
<div class="p-6 rounded-xl bg-secondary/5 border border-secondary/10 flex flex-col items-center text-center">
<span class="material-symbols-outlined text-secondary mb-2" style="font-variation-settings: 'wght' 300;">support_agent</span>
<p class="font-body text-xs text-on-surface-variant leading-relaxed">Technical issues during the exam? <br/> <span class="text-secondary font-bold cursor-pointer">Contact Proctoring Support</span></p>
</div>
</aside>
</main>
<!-- Visual texture element -->
<div class="fixed -bottom-32 -left-32 w-96 h-96 bg-primary/5 rounded-full blur-[120px] pointer-events-none z-0"></div>
<div class="fixed top-32 -right-32 w-64 h-64 bg-secondary/5 rounded-full blur-[100px] pointer-events-none z-0"></div>
</body></html>