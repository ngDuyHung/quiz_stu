<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $quiz->name }} – Làm bài thi</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary":            "#003466",
                        "primary-container":  "#1a4b84",
                        "secondary":          "#1a6299",
                        "on-primary":         "#ffffff",
                        "on-secondary":       "#ffffff",
                        "error":              "#ba1a1a",
                        "surface":            "#f7f9fb",
                        "on-surface":         "#191c1e",
                        "surface-container":  "#eceef0",
                        "outline":            "#737781",
                        "outline-variant":    "#c3c6d1",
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body:     ["Inter"],
                    },
                },
            },
        };
    </script>

    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Manrope', sans-serif; }

        .page-fade { animation: fadeIn .35s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c3c6d1; border-radius: 10px; }

        /* Timer urgency pulse */
        @keyframes urgentPulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: .5; }
        }
        .timer-urgent { animation: urgentPulse 1s ease-in-out infinite; }

        /* Option hover ring */
        .option-label { transition: border-color .15s, background-color .15s; }
        .option-label:hover { border-color: rgba(0,52,102,.35); }
        .option-selected { border-color: #003466 !important; background-color: rgba(0,52,102,.06); }
        .option-badge { transition: background-color .15s, color .15s; }
        .option-selected .option-badge { background-color: #003466; color: #fff; }

        /* Camera preview ring */
        #camera-preview { border: 3px solid #003466; }
    </style>
</head>

<body class="bg-surface text-on-surface min-h-screen">

{{-- ═══════════════════════════════════════════════════════
     CAMERA MODAL (hiển thị trước khi vào bài nếu require_camera)
═══════════════════════════════════════════════════════ --}}
@if($quiz->require_camera)
<div id="camera-modal" class="fixed inset-0 bg-primary/90 backdrop-blur-sm z-[200] flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl text-center">
        <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-4xl text-primary">videocam</span>
        </div>
        <h2 class="text-2xl font-bold text-primary mb-2">Yêu cầu xác thực Camera</h2>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">
            Bài thi này yêu cầu bật webcam để xác thực danh tính.<br />
            Ảnh chụp sẽ được lưu làm bằng chứng thi cử.
        </p>

        <video id="camera-preview" class="w-full rounded-2xl mb-4 hidden bg-slate-100" autoplay playsinline muted></video>
        <canvas id="camera-canvas" class="hidden"></canvas>

        <p id="camera-status" class="text-sm text-slate-500 mb-4"></p>
        <p id="camera-error"  class="text-sm text-error mb-4 hidden"></p>

        <button id="btn-enable-camera" onclick="enableCamera()"
            class="w-full flex items-center justify-center gap-2 py-3.5 bg-primary text-white rounded-2xl font-bold hover:bg-primary/90 transition-all mb-3">
            <span class="material-symbols-outlined">videocam</span>
            Bật Camera &amp; Vào bài
        </button>
        <button id="btn-capture" onclick="capturePhoto()"
            class="w-full flex items-center justify-center gap-2 py-3.5 bg-secondary text-white rounded-2xl font-bold hover:bg-secondary/90 transition-all hidden">
            <span class="material-symbols-outlined">photo_camera</span>
            Chụp ảnh &amp; Bắt đầu làm bài
        </button>
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════════════════════
     SIDEBAR PHẢI – danh sách câu hỏi
═══════════════════════════════════════════════════════ --}}
<nav class="fixed right-0 top-0 h-full w-64 border-l border-slate-200 bg-slate-50 z-50 shadow-xl flex flex-col">
    {{-- Logo --}}
    <div class="p-6 border-b border-slate-200">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center text-white shadow">
                <span class="material-symbols-outlined text-lg">school</span>
            </div>
            <div>
                <h1 class="text-base font-bold text-primary leading-tight">Quiz – STU</h1>
                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Exam Mode</p>
            </div>
        </div>
    </div>

    {{-- Progress --}}
    <div class="px-5 py-3 border-b border-slate-200 flex items-center justify-between text-xs font-bold text-slate-500 uppercase tracking-wide">
        <span>Tiến độ</span>
        <span id="progress-text" class="text-primary">0 / {{ count($questionsData) }}</span>
    </div>

    {{-- Legend --}}
    <div class="px-5 py-2 flex gap-4 text-[10px] font-bold text-slate-400 border-b border-slate-100">
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-primary inline-block"></span> Đã làm</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-white border border-slate-300 inline-block"></span> Chưa làm</span>
    </div>

    {{-- Question grid --}}
    <div class="flex-1 overflow-y-auto px-5 py-4">
        <div id="question-grid" class="grid grid-cols-5 gap-1.5"></div>
    </div>

    {{-- Submit button --}}
    <div class="p-5 border-t border-slate-200">
        <button onclick="confirmSubmit()"
            class="w-full flex items-center justify-center gap-2 py-3.5 bg-error text-white rounded-2xl font-bold shadow-lg shadow-error/20 hover:bg-error/90 hover:scale-[1.01] transition-all text-sm">
            <span class="material-symbols-outlined">send</span>
            Nộp bài thi
        </button>
        <p class="text-center text-[10px] text-slate-400 mt-2">Hoặc đợi hết giờ – tự động nộp</p>
    </div>
</nav>

{{-- ═══════════════════════════════════════════════════════
     HEADER – tên bài thi + đồng hồ + thông tin SV
═══════════════════════════════════════════════════════ --}}
<header class="fixed top-0 left-0 right-64 h-16 flex items-center justify-between px-6 z-40 bg-white/90 backdrop-blur-xl border-b border-slate-200/60 shadow-sm">
    <div class="flex items-center gap-3 min-w-0">
        <a href="{{ route('client.exams') }}" onclick="return confirmLeave()"
           class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 transition-all flex-shrink-0" title="Thoát (bài sẽ được lưu)">
            <span class="material-symbols-outlined text-xl">arrow_back</span>
        </a>
        <div class="min-w-0">
            <h2 class="text-sm font-bold text-primary truncate">{{ $quiz->name }}</h2>
            <p class="text-[10px] text-slate-400">{{ count($questionsData) }} câu · {{ $quiz->duration_minutes }} phút</p>
        </div>
    </div>

    <div class="flex items-center gap-6 flex-shrink-0">
        {{-- Countdown timer --}}
        <div class="text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-0.5">Thời gian còn lại</p>
            <p id="timer-display" class="text-2xl font-black font-mono text-primary tracking-tight leading-none">
                {{ gmdate('i:s', $remainingSeconds) }}
            </p>
        </div>

        <div class="h-8 w-px bg-slate-200"></div>

        {{-- User info --}}
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs font-bold text-primary">{{ Auth::user()->last_name }} {{ Auth::user()->first_name }}</p>
                <p class="text-[10px] text-slate-400">{{ Auth::user()->student_code }}</p>
            </div>
            @if(Auth::user()->photo)
                <img class="w-9 h-9 rounded-full border-2 border-primary/20 object-cover"
                     src="{{ asset('storage/' . Auth::user()->photo) }}" alt="avatar" />
            @else
                <div class="w-9 h-9 rounded-full border-2 border-primary/20 bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-lg">person</span>
                </div>
            @endif
        </div>
    </div>
</header>

{{-- ═══════════════════════════════════════════════════════
     MAIN – hiển thị câu hỏi hiện tại
═══════════════════════════════════════════════════════ --}}
<main class="mr-64 pt-20 px-6 pb-10">
    <div id="question-container" class="max-w-3xl mx-auto"></div>
</main>

{{-- Form nộp bài (ẩn) --}}
<form id="submit-form" method="POST" action="{{ route('client.quiz.submit', $result) }}">
    @csrf
    <input type="hidden" name="photo_proof_base64" id="photo-proof-input" />
</form>

{{-- Toast thông báo --}}
<div id="save-toast"
     class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg opacity-0 transition-opacity duration-300 pointer-events-none z-[300]">
    Đã lưu đáp án
</div>

{{-- ═══════════════════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════════════ --}}
<script>
/* ──────────────────────────────────
   1.  DỮ LIỆU TỪ PHP
────────────────────────────────── */
const QUIZ = {
    requireCamera: {{ $quiz->require_camera ? 'true' : 'false' }},
    saveUrl:        '{{ route('client.quiz.save-answer', $result) }}',
    csrfToken:      '{{ csrf_token() }}',
    questions:      @json($questionsData),
    remainingSeconds: {{ $remainingSeconds }},
};

/* ──────────────────────────────────
   2.  STATE
────────────────────────────────── */
let currentIdx       = 0;
let remainingSeconds = QUIZ.remainingSeconds;
let timerInterval    = null;
let capturedPhoto    = null;
let savingQueue      = {};   // question_id → pending AJAX

// Khởi tạo map đáp án đã chọn từ server (nếu sinh viên load lại trang)
const answeredMap = {};
QUIZ.questions.forEach(q => {
    if (q.selected_option_id) {
        answeredMap[q.question_id] = q.selected_option_id;
    }
});

/* ──────────────────────────────────
   3.  TIMER
────────────────────────────────── */
function startTimer() {
    updateTimerDisplay();
    timerInterval = setInterval(() => {
        remainingSeconds--;
        updateTimerDisplay();
        if (remainingSeconds <= 0) {
            clearInterval(timerInterval);
            document.getElementById('timer-display').textContent = '00:00';
            autoSubmit();
        }
    }, 1000);
}

function updateTimerDisplay() {
    const s   = Math.max(0, remainingSeconds);
    const m   = Math.floor(s / 60);
    const sec = s % 60;
    const txt = String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
    const el  = document.getElementById('timer-display');
    el.textContent = txt;
    el.classList.toggle('text-error',  s < 300);   // đỏ khi < 5 phút
    el.classList.toggle('text-primary', s >= 300);
    el.classList.toggle('timer-urgent', s < 60);    // nhấp nháy khi < 1 phút
}

/* ──────────────────────────────────
   4.  RENDER
────────────────────────────────── */
function renderApp() {
    renderSidebar();
    renderQuestion();
}

function renderSidebar() {
    const grid      = document.getElementById('question-grid');
    const answered  = Object.keys(answeredMap).length;
    document.getElementById('progress-text').textContent = answered + ' / ' + QUIZ.questions.length;

    grid.innerHTML = QUIZ.questions.map((q, idx) => {
        const isDone    = answeredMap[q.question_id] != null;
        const isCurrent = idx === currentIdx;

        let cls = isDone
            ? 'bg-primary text-white border-transparent shadow-sm'
            : 'bg-white text-slate-400 border-slate-200';
        if (isCurrent) cls = 'ring-2 ring-primary bg-primary/10 text-primary border-transparent';

        const num = String(idx + 1).padStart(2, '0');
        return `<button onclick="goTo(${idx})"
                    class="h-8 rounded-lg border text-[11px] font-bold transition-all ${cls} hover:ring-2 hover:ring-primary/40"
                    title="Câu ${idx + 1}${isDone ? ' – Đã làm' : ''}">${num}</button>`;
    }).join('');
}

function renderQuestion() {
    const q               = QUIZ.questions[currentIdx];
    const selectedOptionId = answeredMap[q.question_id] || null;
    const container        = document.getElementById('question-container');
    const progress         = Math.round(((currentIdx + 1) / QUIZ.questions.length) * 100);
    const total            = QUIZ.questions.length;
    const isLast           = currentIdx === total - 1;

    const optionsHtml = q.options.map((opt, i) => {
        const letter    = String.fromCharCode(65 + i);
        const isSelected = opt.id === selectedOptionId;
        const selectedCls = isSelected ? 'option-selected' : '';

        return `
        <label class="option-label ${selectedCls} group flex items-center p-5 rounded-2xl border-2 border-slate-100 cursor-pointer select-none">
            <input type="radio" name="q_${q.question_id}" value="${opt.id}"
                   class="hidden" ${isSelected ? 'checked' : ''}
                   onchange="selectOption(${q.question_id}, ${opt.id})" />
            <div class="option-badge w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center font-extrabold text-sm bg-slate-100 text-slate-500 group-hover:bg-primary/10 group-hover:text-primary mr-4 transition-all">
                ${letter}
            </div>
            <span class="text-base font-medium leading-snug ${isSelected ? 'text-primary font-bold' : 'text-slate-700'}">${escapeHtml(opt.content)}</span>
        </label>`;
    }).join('');

    container.innerHTML = `
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 overflow-hidden page-fade">
        {{-- Progress bar --}}
        <div class="h-1.5 bg-slate-100 w-full">
            <div class="bg-primary h-full transition-all duration-500" style="width:${progress}%"></div>
        </div>

        <div class="p-8 md:p-10">
            {{-- Question header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <span class="px-4 py-1.5 rounded-xl bg-primary/10 text-primary text-xs font-extrabold uppercase tracking-wider">
                        Câu ${currentIdx + 1} / ${total}
                    </span>
                    ${selectedOptionId ? '<span class="flex items-center gap-1 text-xs font-bold text-green-600"><span class="material-symbols-outlined text-sm" style="font-size:14px;font-variation-settings:\'FILL\' 1">check_circle</span> Đã trả lời</span>' : ''}
                </div>
                <div id="save-spinner-${q.question_id}" class="hidden">
                    <span class="material-symbols-outlined text-slate-400 text-lg animate-spin">autorenew</span>
                </div>
            </div>

            {{-- Question content --}}
            <div class="mb-8">
                <div class="text-xl md:text-2xl font-bold text-on-surface leading-snug question-content">
                    ${q.content}
                </div>
            </div>

            {{-- Options --}}
            <div class="space-y-3 mb-10">
                ${optionsHtml}
            </div>

            {{-- Navigation --}}
            <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                <button onclick="prevQuestion()"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-2xl font-bold text-slate-500 hover:bg-slate-100 transition-all text-sm ${currentIdx === 0 ? 'opacity-30 pointer-events-none' : ''}">
                    <span class="material-symbols-outlined text-lg">arrow_back</span> Câu trước
                </button>
                <span class="text-xs text-slate-400">${currentIdx + 1} / ${total}</span>
                <button onclick="${isLast ? 'confirmSubmit()' : 'nextQuestion()'}"
                    class="flex items-center gap-2 px-6 py-2.5 rounded-2xl font-bold
                           ${isLast ? 'bg-error text-white shadow-lg shadow-error/20 hover:bg-error/90' : 'bg-secondary text-white hover:bg-secondary/90'}
                           transition-all text-sm">
                    ${isLast
                        ? '<span class="material-symbols-outlined text-lg">send</span> Nộp bài'
                        : 'Câu tiếp <span class="material-symbols-outlined text-lg">arrow_forward</span>'}
                </button>
            </div>
        </div>
    </div>`;
}

/* Helpers */
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

/* ──────────────────────────────────
   5.  NAVIGATION
────────────────────────────────── */
window.goTo = function(idx) {
    currentIdx = idx;
    renderApp();
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

window.nextQuestion = function() {
    if (currentIdx < QUIZ.questions.length - 1) {
        currentIdx++;
        renderApp();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

window.prevQuestion = function() {
    if (currentIdx > 0) {
        currentIdx--;
        renderApp();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

/* ──────────────────────────────────
   6.  CHỌN ĐÁP ÁN + AJAX LƯU
────────────────────────────────── */
window.selectOption = function(questionId, optionId) {
    answeredMap[questionId] = optionId;
    renderApp();
    saveAnswerAjax(questionId, optionId);
};

function saveAnswerAjax(questionId, optionId) {
    // Hiện spinner
    const spinner = document.getElementById('save-spinner-' + questionId);
    if (spinner) spinner.classList.remove('hidden');

    fetch(QUIZ.saveUrl, {
        method:  'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': QUIZ.csrfToken,
            'Accept':       'application/json',
        },
        body: JSON.stringify({ question_id: questionId, option_id: optionId }),
    })
    .then(r => r.json())
    .then(data => {
        if (spinner) spinner.classList.add('hidden');
        if (data.success) {
            showToast('Đã lưu đáp án');
        }
    })
    .catch(() => {
        if (spinner) spinner.classList.add('hidden');
        showToast('⚠ Lỗi lưu – đáp án sẽ nộp khi submit', 3000);
    });
};

/* ──────────────────────────────────
   7.  SUBMIT
────────────────────────────────── */
window.confirmSubmit = function() {
    const unanswered = QUIZ.questions.filter(q => !answeredMap[q.question_id]).length;
    if (unanswered > 0) {
        if (!confirm(`Còn ${unanswered} câu chưa trả lời.\nBạn có chắc chắn muốn nộp bài?`)) return;
    } else {
        if (!confirm('Bạn đã trả lời hết tất cả câu hỏi.\nXác nhận nộp bài?')) return;
    }
    doSubmit();
};

function autoSubmit() {
    showToast('⏰ Hết giờ! Đang nộp bài tự động...', 4000);
    setTimeout(doSubmit, 1500);
}

function doSubmit() {
    clearInterval(timerInterval);
    if (capturedPhoto) {
        document.getElementById('photo-proof-input').value = capturedPhoto;
    }
    // Disable submit button to prevent double submit
    document.querySelectorAll('button[onclick*="Submit"], button[onclick*="submit"]')
        .forEach(b => { b.disabled = true; b.textContent = 'Đang nộp bài...'; });
    document.getElementById('submit-form').submit();
}

/* ──────────────────────────────────
   8.  CAMERA
────────────────────────────────── */
let cameraStream = null;

window.enableCamera = async function() {
    const statusEl = document.getElementById('camera-status');
    const errorEl  = document.getElementById('camera-error');
    const preview  = document.getElementById('camera-preview');
    const btnEnable = document.getElementById('btn-enable-camera');
    const btnCapture = document.getElementById('btn-capture');

    errorEl.classList.add('hidden');
    statusEl.textContent = 'Đang yêu cầu quyền truy cập camera...';

    try {
        cameraStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        preview.srcObject = cameraStream;
        preview.classList.remove('hidden');
        statusEl.textContent = 'Camera đã bật. Hãy nhìn thẳng vào camera rồi chụp ảnh.';
        btnEnable.classList.add('hidden');
        btnCapture.classList.remove('hidden');
    } catch (err) {
        errorEl.textContent = 'Không thể truy cập camera: ' + err.message
            + '. Hãy kiểm tra quyền trình duyệt.';
        errorEl.classList.remove('hidden');
        statusEl.textContent = '';
    }
};

window.capturePhoto = function() {
    const preview = document.getElementById('camera-preview');
    const canvas  = document.getElementById('camera-canvas');

    canvas.width  = preview.videoWidth  || 640;
    canvas.height = preview.videoHeight || 480;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(preview, 0, 0, canvas.width, canvas.height);

    capturedPhoto = canvas.toDataURL('image/jpeg', 0.8);

    // Dừng stream sau khi chụp
    if (cameraStream) {
        cameraStream.getTracks().forEach(t => t.stop());
        cameraStream = null;
    }

    // Đóng modal và bắt đầu timer
    document.getElementById('camera-modal').classList.add('hidden');
    startTimer();
    showToast('Ảnh xác thực đã được chụp. Bắt đầu làm bài!', 3000);
};

/* ──────────────────────────────────
   9.  TOAST NOTIFICATION
────────────────────────────────── */
let toastTimer = null;
function showToast(msg, duration = 1800) {
    const el = document.getElementById('save-toast');
    el.textContent = msg;
    el.classList.remove('opacity-0');
    el.classList.add('opacity-100');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        el.classList.remove('opacity-100');
        el.classList.add('opacity-0');
    }, duration);
}

/* ──────────────────────────────────
   10. LEAVE GUARD
────────────────────────────────── */
window.confirmLeave = function() {
    return confirm('Bạn có muốn thoát không?\nBài làm sẽ được lưu và tiếp tục sau.');
};

window.addEventListener('beforeunload', (e) => {
    if (remainingSeconds > 0) {
        e.preventDefault();
        e.returnValue = '';
    }
});

/* ──────────────────────────────────
   11. KHỞI TẠO
────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    renderApp();

    @if($quiz->require_camera)
        // Timer sẽ bắt đầu sau khi chụp ảnh
    @else
        startTimer();
    @endif
});
</script>

</body>
</html>
