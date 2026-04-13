/**
 * 1. DỮ LIỆU TẬP TRUNG (IT SPECIALIZED)
 */
const store = {
    user: { 
        name: "ALEX NGUYEN", 
        id: "20240001", 
        gpa: 8.82, 
        progress: 85,
        gitContributions: 450,
        avatar: "https://i.pravatar.cc/150?u=alex" 
    },
    activeExam: {
        id: "IT4421",
        title: "Lập trình Web Nâng cao (Laravel)",
        desc: "Kiểm tra kiến thức về MVC, Eloquent ORM và RESTful API Design.",
        duration: "60 phút",
        questions: 40
    },
    courses: [
        { id: "AND-202", name: "Android App Development (Kotlin)", teacher: "Dr. Tech", credits: 4.0, progress: 75, status: "Learning" },
        { id: "CPP-101", name: "Advanced C++ & Data Structures", teacher: "Prof. Binary", credits: 3.0, progress: 100, status: "Completed" },
        { id: "WEB-305", name: "Backend Master: Laravel & PHP", teacher: "Dev Master", credits: 3.0, progress: 60, status: "Learning" },
        { id: "BC-101", name: "Blockchain Fundamentals", teacher: "Satoshi N.", credits: 2.0, progress: 90, status: "Learning" }
    ],
    upcoming: [
        { title: "CSDL NoSQL (MongoDB)", teacher: "Nguyễn Văn A", date: "20/04", time: "45 Phút", q: 30, icon: "database", color: "bg-secondary-fixed", text: "text-primary" },
        { title: "An toàn Bảo mật TT", teacher: "Trần Thị B", date: "22/04", time: "60 Phút", q: 50, icon: "security", color: "bg-tertiary-fixed", text: "text-tertiary" },
        { title: "Cloud Computing (Docker)", teacher: "Lê Văn C", date: "25/04", time: "40 Phút", q: 20, icon: "cloud_queue", color: "bg-primary-fixed", text: "text-primary" }
    ]
};

/**
 * 2. CÁC THÀNH PHẦN GIAO DIỆN (COMPONENTS)
 */
const Components = {
    // TRANG CHỦ (DASHBOARD)
    home: () => `
        <div class="space-y-8 page-fade">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                <div class="lg:col-span-8">
                    <span class="text-[11px] font-bold tracking-[0.2em] text-secondary uppercase mb-3 block">Developer Console</span>
                    <h1 class="text-5xl font-extrabold text-primary tracking-tight mb-4">Hello ${store.user.name.split(' ')[0]},</h1>
                    <p class="text-lg text-slate-600 max-w-2xl leading-relaxed">
                        Chỉ số Tech-stack của bạn đạt <span class="text-primary font-bold">${store.user.progress}%</span>. Bạn có <span class="text-error font-bold">1 bài kiểm tra</span> cần deploy.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8 bg-white border border-slate-200/60 rounded-[2.5rem] p-10 shadow-sm flex flex-col md:flex-row gap-8 items-center relative overflow-hidden group">
                    <div class="flex-1 relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="px-4 py-1 bg-error/10 text-error rounded-full text-xs font-bold uppercase tracking-widest">Đang mở</span>
                        </div>
                        <h2 class="text-3xl font-black text-primary mb-2">${store.activeExam.title}</h2>
                        <p class="text-slate-500 mb-8 italic">"${store.activeExam.desc}"</p>
                        <button onclick="window.location.href='answer&question.blade.php'" class="bg-primary text-white px-10 py-4 rounded-2xl font-bold flex items-center gap-3 hover:shadow-2xl transition-all active:scale-95">
                            Start Coding <span class="material-symbols-outlined text-sm">terminal</span>
                        </button>
                    </div>
                    <div class="w-48 aspect-square bg-slate-50 rounded-3xl flex items-center justify-center border border-slate-100">
                        <span class="material-symbols-outlined text-primary/20 text-8xl">code</span>
                    </div>
                </div>

                <div class="lg:col-span-4 bg-secondary text-white rounded-[2.5rem] p-10 shadow-xl flex flex-col justify-between relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-xs font-bold opacity-70 uppercase mb-1 tracking-widest">Git Contributions</h3>
                        <p class="text-6xl font-black italic">${store.user.gitContributions}</p>
                    </div>
                    <div class="mt-4 relative z-10">
                        <div class="flex justify-between text-xs font-bold mb-2"><span>GPA: ${store.user.gpa}</span><span>Mục tiêu 92%</span></div>
                        <div class="w-full h-2 bg-white/20 rounded-full overflow-hidden">
                            <div class="bg-white h-full transition-all duration-1000" style="width: 92%"></div>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -left-10 -bottom-10 text-[15rem] opacity-10">auto_awesome</span>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-2xl font-black text-primary">Kỳ thi sắp tới</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    ${store.upcoming.map(exam => `
                        <div class="bg-white border border-slate-200/50 p-6 rounded-[2rem] hover:shadow-lg transition-all group">
                            <div class="w-12 h-12 rounded-xl ${exam.color} ${exam.text} flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined">${exam.icon}</span>
                            </div>
                            <h4 class="font-bold text-primary">${exam.title}</h4>
                            <p class="text-xs text-slate-500 mb-4">GV. ${exam.teacher}</p>
                            <div class="flex justify-between items-center text-[10px] font-bold uppercase text-slate-400">
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">calendar_month</span> ${exam.date}</span>
                                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">terminal</span> ${exam.q} Tasks</span>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        </div>
    `,

    // TRANG KHÓA HỌC (COURSES)
    courses: () => `
        <div class="space-y-8 page-fade">
            <h2 class="text-3xl font-black text-primary">Tech Stack Courses</h2>
            <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Technology</th>
                            <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Instructor</th>
                            <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Progress</th>
                            <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        ${store.courses.map(c => `
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="font-bold text-primary">${c.name}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">${c.id}</div>
                                </td>
                                <td class="px-8 py-6 text-sm text-slate-600 font-medium">${c.teacher}</td>
                                <td class="px-8 py-6">
                                    <div class="w-32 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full" style="width: ${c.progress}%"></div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase ${c.status === 'Completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'}">${c.status}</span>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        </div>
    `,

    results: () => `<div class="p-20 text-center page-fade text-slate-400 italic">Fetching Build History from server...</div>`,
    ranking: () => `<div class="p-20 text-center page-fade text-slate-400 italic">Loading Leaderboard...</div>`
};

/**
 * 3. HỆ THỐNG ĐIỀU HƯỚNG (ROUTING)
 */
function router() {
    // Tự động nhảy về Dashboard nếu không có hash
    if (!window.location.hash || window.location.hash === '#') {
        window.location.hash = '#home';
        return;
    }

    const hash = window.location.hash;
    const route = hash.replace('#', '');
    const viewport = document.getElementById('app-viewport');

    if (viewport) {
        viewport.innerHTML = (Components[route] || Components.home)();
        window.scrollTo(0, 0);
    }

    // Cập nhật Active Sidebar
    document.querySelectorAll('.nav-item').forEach(link => {
        const isActive = link.getAttribute('href') === hash;
        link.classList.toggle('bg-primary/10', isActive);
        link.classList.toggle('text-primary', isActive);
        link.classList.toggle('font-bold', isActive);
        link.classList.toggle('border-r-4', isActive);
        link.classList.toggle('border-primary', isActive);
        
        const icon = link.querySelector('.material-symbols-outlined');
        if (icon) icon.style.fontVariationSettings = isActive ? "'FILL' 1" : "'FILL' 0";
    });
}



/**
 * 4. KHỞI CHẠY
 */
function initApp() {
    const userHeader = document.getElementById('header-user-info');
    if (userHeader) {
        userHeader.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-primary">${store.user.name}</p>
                    <p class="text-[10px] text-slate-500 font-bold uppercase">ID: ${store.user.id}</p>
                </div>
                <img src="${store.user.avatar}" class="w-10 h-10 rounded-full border-2 border-primary/10" />
            </div>
        `;
    }
    router();
}

window.addEventListener('hashchange', router);
window.addEventListener('DOMContentLoaded', initApp);