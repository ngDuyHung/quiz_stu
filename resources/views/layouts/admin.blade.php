<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Axiom Academic Admin')</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@300;400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#000666",
                        "primary-container": "#1a237e",
                        "secondary": "#00639a",
                        "secondary-container": "#51b2fe",
                        "surface": "#f8f9fa",
                        "surface-container-low": "#f3f4f5",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .font-manrope { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        /* Hiệu ứng SPA-like cho content */
        .page-transition { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
    @stack('css')
</head>
<body class="text-slate-900">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="flex-grow flex flex-col bg-surface overflow-x-hidden">
            @include('partials.navbar')

            @include('partials.flash-message')

            <div class="px-8 pb-12 flex-grow page-transition">
                @yield('content')
            </div>

            @includeIf('partials.footer')
        </main>
    </div>
    @stack('scripts')
</body>
</html>