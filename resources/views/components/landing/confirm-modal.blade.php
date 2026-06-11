<div id="confirmModal" class="fixed inset-0 z-[130] hidden items-center justify-center bg-black/70 px-4">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#111122] p-6 shadow-2xl">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-white">{{ $title }}</h2>

            <button onclick="closeConfirmModal()" class="rounded-xl bg-white/10 p-2 hover:bg-white/15">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <p class="mt-4 text-sm leading-6 text-slate-300">
            {{ $message }}
        </p>

        <div class="mt-6 flex justify-end">
            <button onclick="closeConfirmModal()" class="rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-6 py-3 text-sm font-bold text-white hover:opacity-90">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>