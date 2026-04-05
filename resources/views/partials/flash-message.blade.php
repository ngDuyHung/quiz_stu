<div class="px-8 mt-4">
    @if(session('success'))
    <div class="bg-primary text-white px-6 py-4 rounded-full flex items-center justify-between shadow-lg shadow-primary/10 animate-fade-in-down">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-secondary-container" style="font-variation-settings: 'FILL' 1;">verified</span>
            <span class="font-manrope font-semibold text-sm">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="hover:bg-white/10 p-1 rounded-full"><span class="material-symbols-outlined text-sm">close</span></button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-error text-white px-6 py-4 rounded-full flex items-center justify-between shadow-lg shadow-error/10">
        <div class="flex items-center gap-3 text-sm">
            <span class="material-symbols-outlined text-white">report</span>
            <span class="font-manrope font-semibold">{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="hover:bg-white/10 p-1 rounded-full"><span class="material-symbols-outlined text-sm">close</span></button>
    </div>
    @endif
</div>