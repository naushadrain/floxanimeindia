<article onclick="openDetailModal({{ $realIndex }})"
         class="h-[310px] w-[165px] shrink-0 cursor-pointer overflow-hidden rounded-3xl border border-white/10 bg-[#111122] shadow-xl transition hover:bg-white/[0.05] sm:h-[340px] sm:w-[220px] lg:h-[360px] lg:w-[250px]">

    <div class="relative aspect-video overflow-hidden bg-black">
        <img src="{{ $item['image'] }}"
             class="h-full w-full object-cover"
             alt="{{ $item['title'] }}">

        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

        <span class="absolute left-2 top-2 rounded-full bg-fuchsia-500 px-2.5 py-1 text-[9px] font-black text-white">
            EP {{ $item['episodes'] }}
        </span>

        <span class="absolute right-2 top-2 rounded-full bg-black/60 px-2.5 py-1 text-[9px] font-bold text-yellow-400">
            ★ {{ $item['rating'] }}
        </span>

        <button onclick="event.stopPropagation(); openFullVideo({{ $realIndex }})"
                class="absolute left-1/2 top-1/2 flex h-11 w-11 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white">
            <i data-lucide="play" class="h-5 w-5 fill-white"></i>
        </button>
    </div>

    <div class="flex h-[calc(100%-93px)] flex-col p-3 sm:h-[calc(100%-124px)] lg:h-[calc(100%-141px)]">
        <span class="mb-1.5 w-fit rounded-full bg-fuchsia-500/20 px-2 py-0.5 text-[9px] font-bold text-fuchsia-300">
            {{ $item['category'] }}
        </span>

        <h3 class="line-clamp-1 text-sm font-black text-white">
            {{ $item['title'] }}
        </h3>

        <p class="mt-1 line-clamp-2 text-[11px] leading-4 text-slate-400">
            {{ $item['description'] }}
        </p>

        <button onclick="event.stopPropagation(); openFullVideo({{ $realIndex }})"
                class="mt-auto flex w-full items-center justify-center gap-1.5 rounded-2xl bg-white/10 py-2 text-xs font-bold text-white">
            <i data-lucide="play" class="h-3.5 w-3.5 fill-white"></i>
            Play
        </button>
    </div>
</article>