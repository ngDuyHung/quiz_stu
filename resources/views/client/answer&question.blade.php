<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Làm bài thi - Quiz STU</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
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

        /* Hiệu ứng xoay nhẹ cho vòng thời gian */
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 12s linear infinite;
        }
    </style>
</head>

<body class="bg-surface text-on-background min-h-screen">
    <nav class="flex flex-col fixed right-0 top-0 h-full w-64 border-l border-slate-200 bg-slate-50 z-50 shadow-xl">
        <div class="p-8 pb-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white shadow-lg">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-[#003466]">Quiz - STU</h1>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Exam Mode</p>
                </div>
            </div>
        </div>

        <div class="flex-1 px-4 overflow-y-auto pb-6">
            <div class="mb-4 flex items-center justify-between px-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tiến độ</span>
                <span id="progress-text" class="text-xs font-bold text-primary">0/40</span>
            </div>
            <div id="question-grid" class="grid grid-cols-5 gap-1.5">
                </div>
        </div>

        <div class="p-6 border-t border-slate-200">
            <button onclick="submitExam()" class="w-full flex items-center justify-center gap-3 px-4 py-4 bg-error text-white rounded-2xl font-bold shadow-lg shadow-error/20 hover:scale-[1.02] transition-all">
                <span class="material-symbols-outlined">send</span>
                <span>Nộp bài thi</span>
            </button>
        </div>
    </nav>

    <header class="fixed top-0 left-0 right-64 h-16 flex justify-between items-center px-8 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-200/15">
        <div class="flex items-center gap-4">
            <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600 uppercase tracking-wider">IT4421</span>
            <h2 class="text-sm font-bold text-primary">Lập trình Web nâng cao - Giữa kỳ</h2>
        </div>

        <div class="flex items-center gap-8">
            <div class="text-right">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Thời gian còn lại</p>
                <p id="timer" class="text-xl font-black text-error font-mono">24:59</p>
            </div>
            <div class="h-8 w-[1px] bg-slate-200"></div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-xs font-bold text-primary">ALEX NGUYEN</p>
                    <p class="text-[10px] text-slate-500 font-medium">20240001</p>
                </div>
                <img class="w-10 h-10 rounded-full border-2 border-primary/10" src="https://i.pravatar.cc/150?u=alex" />
            </div>
        </div>
    </header>

    <main class="mr-64 pt-24 px-8 pb-12">
        <div id="question-container" class="max-w-4xl mx-auto space-y-6">
            </div>
    </main>

    <script>
        /**
         * 1. DỮ LIỆU CÂU HỎI (MOCKUP)
         */
        const questions = [
            { id: 1, text: "Laravel là Framework của ngôn ngữ nào?", options: ["Java", "PHP", "Python", "Ruby"], answer: null },
            { id: 2, text: "Trong MVC, 'V' viết tắt của từ gì?", options: ["Version", "View", "Virtual", "Validator"], answer: null },
            { id: 3, text: "Đâu là một ORM của Laravel?", options: ["Eloquent", "Doctrine", "Hibernate", "Entity"], answer: null },
            { id: 4, text: "Thành phần nào xử lý logic nghiệp vụ trong MVC?", options: ["Model", "View", "Controller", "Route"], answer: null },
            { id: 5, text: "Lệnh nào dùng để tạo Controller trong Laravel?", options: ["make:controller", "create:controller", "generate:controller", "new:controller"], answer: null },
            // ... Bạn có thể thêm 40 câu ở đây
        ];

        let currentIdx = 0;

        /**
         * 2. HÀM RENDER GIAO DIỆN
         */
        function renderApp() {
            renderSidebar();
            renderQuestion();
            updateProgress();
        }

        function renderSidebar() {
            const grid = document.getElementById('question-grid');
            grid.innerHTML = questions.map((q, idx) => {
                let statusClass = "bg-white text-slate-400 border-slate-200"; // Chưa làm
                if (idx === currentIdx) statusClass = "ring-2 ring-primary bg-primary/10 text-primary"; // Đang xem
                else if (q.answer !== null) statusClass = "bg-primary text-white border-transparent shadow-sm"; // Đã làm

                return `<button onclick="goToQuestion(${idx})" class="h-8 rounded-lg border text-[11px] font-bold transition-all ${statusClass}">${idx + 1 < 10 ? '0' + (idx + 1) : idx + 1}</button>`;
            }).join('');
        }

        function renderQuestion() {
            const q = questions[currentIdx];
            const container = document.getElementById('question-container');
            
            container.innerHTML = `
                <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-200/50 page-fade relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-100"><div class="bg-primary h-full transition-all" style="width: ${(currentIdx+1)/questions.length*100}%"></div></div>
                    <div class="flex justify-between items-center mb-10">
                        <span class="px-4 py-1.5 rounded-xl bg-primary/10 text-primary text-xs font-extrabold uppercase">Câu hỏi ${q.id}</span>
                    </div>
                    <div class="space-y-8">
                        <h3 class="text-3xl font-bold text-on-surface leading-snug">${q.text}</h3>
                        <div class="grid grid-cols-1 gap-4">
                            ${q.options.map((opt, i) => `
                                <label class="group relative flex items-center p-6 rounded-3xl border-2 cursor-pointer transition-all ${q.answer === i ? 'border-primary bg-primary/5' : 'border-slate-100 hover:border-primary/30'}">
                                    <input type="radio" name="quiz" class="hidden" onchange="selectOption(${i})" ${q.answer === i ? 'checked' : ''}>
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold transition-all ${q.answer === i ? 'bg-primary text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-primary/10 group-hover:text-primary'}">${String.fromCharCode(65 + i)}</div>
                                    <span class="ml-5 text-lg font-medium ${q.answer === i ? 'text-primary font-bold' : 'text-slate-700'}">${opt}</span>
                                </label>
                            `).join('')}
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-12 pt-8 border-t border-slate-100">
                        <button onclick="prevQuestion()" class="flex items-center gap-2 px-6 py-3 rounded-2xl font-bold text-slate-500 hover:bg-slate-100 transition-all ${currentIdx === 0 ? 'opacity-30 pointer-events-none' : ''}">
                            <span class="material-symbols-outlined">arrow_back</span> Câu trước
                        </button>
                        <div class="flex gap-4">
                            <button onclick="nextQuestion()" class="px-10 py-3 rounded-2xl font-bold bg-secondary text-white shadow-xl hover:-translate-y-1 transition-all">
                                ${currentIdx === questions.length - 1 ? 'Hoàn thành' : 'Lưu & Tiếp theo'}
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        /**
         * 3. XỬ LÝ LOGIC ĐIỀU HƯỚNG
         */
        window.goToQuestion = function(idx) {
            currentIdx = idx;
            renderApp();
        };

        window.nextQuestion = function() {
            if (currentIdx < questions.length - 1) {
                currentIdx++;
                renderApp();
            } else {
                alert("Bạn đã đến câu cuối cùng!");
            }
        };

        window.prevQuestion = function() {
            if (currentIdx > 0) {
                currentIdx--;
                renderApp();
            }
        };

        window.selectOption = function(optionIdx) {
            questions[currentIdx].answer = optionIdx;
            renderApp();
        };

        function updateProgress() {
            const solved = questions.filter(q => q.answer !== null).length;
            document.getElementById('progress-text').innerText = `${solved}/${questions.length}`;
        }

        window.submitExam = function() {
            const unsolved = questions.filter(q => q.answer === null).length;
            if(unsolved > 0) {
                if(!confirm(`Bạn còn ${unsolved} câu chưa làm. Vẫn muốn nộp chứ?`)) return;
            }
            alert("Đã nộp bài thành công!");
            window.location.href = "result-detail.blade.php";
        };

        // Khởi tạo lần đầu
        renderApp();
    </script>
</body>
</html>
