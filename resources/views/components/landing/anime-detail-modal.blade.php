<div id="animeDetailModal" class="fixed inset-0 z-[120] hidden items-center justify-center bg-black/75 px-4">
    <div class="max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-3xl border border-white/10 bg-[#111122] shadow-2xl">
        <div class="relative">
            <img
                id="detailImage"
                src=""
                alt=""
                class="h-[320px] w-full rounded-t-3xl object-cover"
            />

            <div class="absolute inset-0 rounded-t-3xl bg-gradient-to-t from-[#111122] via-transparent to-black/30"></div>

            <button
                onclick="closeAnimeDetail()"
                class="absolute right-4 top-4 rounded-xl bg-black/50 p-2 text-white backdrop-blur hover:bg-black/70"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="p-6">
            <div class="mb-4 flex flex-wrap gap-3">
                <span id="detailCategory" class="rounded-full bg-fuchsia-500 px-4 py-1.5 text-sm font-bold text-white"></span>
                <span id="detailYear" class="rounded-full border border-white/10 bg-white/10 px-4 py-1.5 text-sm text-white"></span>
                <span id="detailRating" class="rounded-full border border-white/10 bg-white/10 px-4 py-1.5 text-sm text-white"></span>
            </div>

            <h2 id="detailTitle" class="text-3xl font-black text-white sm:text-4xl"></h2>

            <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-300">
                <span id="detailVotes"></span>
                <span id="detailEpisodes"></span>
                <span id="detailDuration"></span>
            </div>

            <p id="detailDescription" class="mt-5 text-base leading-7 text-slate-300"></p>

            <div class="mt-6 grid gap-4 text-sm sm:grid-cols-2">
                <div class="rounded-2xl border border-white/10 bg-white/[0.05] p-4">
                    <p class="text-slate-400">Studio</p>
                    <p id="detailStudio" class="mt-1 font-bold text-white"></p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.05] p-4">
                    <p class="text-slate-400">Director</p>
                    <p id="detailDirector" class="mt-1 font-bold text-white"></p>
                </div>
            </div>

            <div class="mt-7 flex flex-wrap gap-3">
                <button class="flex h-12 items-center rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-7 font-bold text-white hover:opacity-90">
                    <i data-lucide="play" class="mr-2 h-5 w-5 fill-white"></i>
                    Play Now
                </button>

                <button onclick="openConfirmModal()" class="flex h-12 items-center rounded-2xl border border-white/15 bg-white/10 px-7 font-bold text-white hover:bg-white/15">
                    <i data-lucide="bookmark" class="mr-2 h-5 w-5"></i>
                    My List
                </button>
            </div>
        </div>
    </div>
</div>