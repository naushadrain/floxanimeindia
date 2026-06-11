<div id="genreOffcanvas" class="fixed inset-0 z-[110] hidden">
    <div onclick="closeGenreOffcanvas()" class="absolute inset-0 bg-black/70"></div>

    <div class="absolute right-0 top-0 h-full w-80 border-l border-white/10 bg-[#090918] p-6 text-white shadow-2xl">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black">Genres</h2>

            <button onclick="closeGenreOffcanvas()" class="rounded-xl bg-white/10 p-2 hover:bg-white/15">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="mt-8 grid gap-3">
            @foreach($genres as $genre)
                <button class="rounded-2xl border border-white/10 bg-white/[0.05] px-4 py-3 text-left text-sm font-semibold text-slate-200 hover:bg-white/10">
                    {{ $genre }}
                </button>
            @endforeach
        </div>
    </div>
</div>