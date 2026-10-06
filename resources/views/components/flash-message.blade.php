@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="rounded-2xl bg-emerald-50/90 border border-emerald-200/80 p-4 mb-6 shadow-sm flex items-start justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-emerald-900 uppercase tracking-wider">Berhasil</p>
                <p class="text-sm font-semibold text-emerald-950 mt-0.5">
                    {{ session('success') }}
                </p>
            </div>
        </div>
        <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900 p-1 rounded-lg hover:bg-emerald-100/60 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="rounded-2xl bg-rose-50/90 border border-rose-200/80 p-4 mb-6 shadow-sm flex items-start justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-rose-900 uppercase tracking-wider">Perhatian</p>
                <p class="text-sm font-semibold text-rose-950 mt-0.5">
                    {{ session('error') }}
                </p>
            </div>
        </div>
        <button type="button" @click="show = false" class="text-rose-700 hover:text-rose-900 p-1 rounded-lg hover:bg-rose-100/60 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if (session('info'))
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="rounded-2xl bg-sky-50/90 border border-sky-200/80 p-4 mb-6 shadow-sm flex items-start justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-sky-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-sky-900 uppercase tracking-wider">Informasi</p>
                <p class="text-sm font-semibold text-sky-950 mt-0.5">
                    {{ session('info') }}
                </p>
            </div>
        </div>
        <button type="button" @click="show = false" class="text-sky-700 hover:text-sky-900 p-1 rounded-lg hover:bg-sky-100/60 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif
