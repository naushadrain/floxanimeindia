<div id="profileModal" class="fixed inset-0 z-[120] hidden items-center justify-center bg-black/70 px-4">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-[#111122] p-6 shadow-2xl">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-white">Profile</h2>

            <button onclick="closeProfileModal()" class="rounded-xl bg-white/10 p-2 hover:bg-white/15">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="mt-6 text-center">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500">
                <i data-lucide="user-circle" class="h-12 w-12 text-white"></i>
            </div>

            <h3 class="mt-4 text-lg font-bold text-white">Guest User</h3>
            <p class="mt-1 text-sm text-slate-400">Login to manage your profile.</p>

            <button onclick="openLoginModal(); closeProfileModal();" class="mt-6 w-full rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-4 py-3 font-bold text-white hover:opacity-90">
                LogIn
            </button>
        </div>
    </div>
</div>