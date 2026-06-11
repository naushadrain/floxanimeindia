<div class="group relative flex flex-col overflow-hidden rounded-3xl border border-white/10 bg-white/[0.04] shadow-xl transition duration-300 hover:-translate-y-1 hover:border-fuchsia-500/30 hover:shadow-fuchsia-500/10 hover:shadow-2xl">

    {{-- ── Poster ──────────────────────────────────────────────────────── --}}
    <div class="relative overflow-hidden" style="aspect-ratio:2/3;">

        <img
            src="{{ $item['image'] }}"
            alt="{{ $item['title'] }}"
            loading="lazy"
            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
        />

        {{-- gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

        {{-- category badge --}}
        <span class="absolute left-3 top-3 rounded-full bg-black/60 px-3 py-1 text-[11px] font-bold text-white backdrop-blur-sm">
            {{ $item['category'] }}
        </span>

        {{-- rating badge --}}
        <span class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-black/60 px-2.5 py-1 text-[11px] font-bold text-yellow-400 backdrop-blur-sm">
            <i data-lucide="star" class="h-3 w-3 fill-yellow-400 text-yellow-400"></i>
            {{ $item['rating'] }}
        </span>

        {{-- title + meta at bottom of poster --}}
        <div class="absolute bottom-0 left-0 right-0 p-3">
            <h3 class="line-clamp-1 text-sm font-black text-white drop-shadow">{{ $item['title'] }}</h3>
            <p class="mt-0.5 text-[11px] text-slate-400">{{ $item['year'] }} · {{ $item['episodes'] }} eps</p>
        </div>

        {{-- hover play overlay --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 bg-black/50 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
            <button
                onclick="event.stopPropagation(); openVideoPlayer({{ $index }})"
                class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 text-white shadow-xl shadow-fuchsia-500/40 transition hover:scale-110 active:scale-95"
                aria-label="Play {{ $item['title'] }}"
            >
                <i data-lucide="play" class="h-6 w-6 fill-white translate-x-0.5"></i>
            </button>
            <button
                onclick="event.stopPropagation(); openAnimeDetail({{ $index }})"
                class="flex items-center gap-1.5 rounded-full border border-white/30 bg-white/10 px-4 py-1.5 text-xs font-semibold text-white backdrop-blur-sm hover:bg-white/20 transition"
            >
                <i data-lucide="info" class="h-3.5 w-3.5"></i>
                More Info
            </button>
        </div>
    </div>

    {{-- ── Card body ────────────────────────────────────────────────────── --}}
    <div class="flex flex-1 flex-col p-4">
        <p class="line-clamp-2 text-xs leading-5 text-slate-400">{{ $item['description'] }}</p>

        <div class="mt-auto pt-3 flex items-center gap-2">
            <button
                onclick="openVideoPlayer({{ $index }})"
                class="flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-gradient-to-r from-violet-500 to-fuchsia-500 py-2 text-xs font-bold text-white shadow-md shadow-fuchsia-500/20 hover:opacity-90 transition active:scale-95"
            >
                <i data-lucide="play" class="h-3.5 w-3.5 fill-white"></i>
                Play
            </button>
            <button
                onclick="openAnimeDetail({{ $index }})"
                class="flex items-center justify-center rounded-xl border border-white/10 bg-white/6 p-2 text-slate-300 hover:bg-white/12 hover:text-white transition"
                aria-label="More info"
            >
                <i data-lucide="info" class="h-3.5 w-3.5"></i>
            </button>
        </div>
    </div>
</div>
