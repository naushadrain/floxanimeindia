{{-- CoCoFlix-style portrait card — used inside horizontal scroll rows --}}
<div class="group relative shrink-0 w-32 sm:w-36 lg:w-44 cursor-pointer"
     onclick="openAnimeDetail({{ $index }})">

    {{-- Poster 2:3 aspect ratio --}}
    <div class="relative overflow-hidden rounded-xl" style="aspect-ratio:2/3">

        <img src="{{ $item['image'] }}"
             alt="{{ $item['title'] }}"
             loading="lazy"
             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">

        {{-- Bottom gradient overlay --}}
        <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/30 to-transparent"></div>

        {{-- Top-left: category badge --}}
        <span class="absolute left-1.5 top-1.5 rounded-md bg-fuchsia-500/90 px-1.5 py-0.5 text-[9px] font-bold text-white backdrop-blur-sm leading-none">
            {{ $item['category'] }}
        </span>

        {{-- Top-right: rating badge --}}
        <span class="absolute right-1.5 top-1.5 flex items-center gap-0.5 rounded-md bg-black/70 px-1.5 py-0.5 text-[9px] font-bold text-yellow-400 backdrop-blur-sm leading-none">
            <i data-lucide="star" class="h-2.5 w-2.5 fill-yellow-400 text-yellow-400"></i>
            {{ $item['rating'] }}
        </span>

        {{-- Bottom: title + year --}}
        <div class="absolute bottom-0 left-0 right-0 p-2">
            <h3 class="line-clamp-2 text-[11px] font-black leading-tight text-white drop-shadow">
                {{ $item['title'] }}
            </h3>
            <p class="mt-0.5 text-[9px] text-slate-400">
                {{ $item['year'] }} &middot; {{ $item['episodes'] }} eps
            </p>
        </div>

        {{-- Hover / tap: play overlay --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-black/50
                    opacity-0 transition-opacity duration-200 group-hover:opacity-100">
            <button onclick="event.stopPropagation(); openVideoPlayer({{ $index }})"
                    class="flex h-10 w-10 items-center justify-center rounded-full
                           bg-linear-to-br from-violet-500 to-fuchsia-500
                           text-white shadow-xl shadow-fuchsia-500/40
                           transition hover:scale-110 active:scale-95"
                    aria-label="Play {{ $item['title'] }}">
                <i data-lucide="play" class="h-4 w-4 fill-white translate-x-0.5"></i>
            </button>
            <button onclick="event.stopPropagation(); openConfirmModal()"
                    class="flex items-center gap-1 rounded-full border border-white/30 bg-white/10 px-3 py-1
                           text-[10px] font-semibold text-white backdrop-blur-sm hover:bg-white/20 transition">
                <i data-lucide="plus" class="h-2.5 w-2.5"></i>
                Add
            </button>
        </div>
    </div>
</div>
