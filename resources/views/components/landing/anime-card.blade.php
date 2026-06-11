<div
    onclick="openAnimeDetail({{ $index }})"
    class="group min-w-[190px] cursor-pointer overflow-hidden rounded-3xl border border-white/10 bg-white/[0.04] shadow-xl transition hover:-translate-y-1 hover:bg-white/[0.07]"
>
    <div class="relative h-[270px] overflow-hidden">
        <img
            src="{{ $item['image'] }}"
            alt="{{ $item['title'] }}"
            class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
        />

        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>

        <div class="absolute left-3 top-3 rounded-full bg-black/60 px-3 py-1 text-xs font-bold text-white backdrop-blur">
            {{ $item['category'] }}
        </div>

        <div class="absolute bottom-3 left-3 right-3">
            <h3 class="line-clamp-1 text-base font-black text-white">
                {{ $item['title'] }}
            </h3>

            <div class="mt-2 flex items-center gap-2 text-xs text-slate-300">
                <span class="flex items-center gap-1">
                    <i data-lucide="star" class="h-3.5 w-3.5 fill-yellow-400 text-yellow-400"></i>
                    {{ $item['rating'] }}
                </span>

                <span>•</span>
                <span>{{ $item['year'] }}</span>
            </div>
        </div>

        <div class="absolute inset-0 hidden items-center justify-center bg-black/40 group-hover:flex">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-fuchsia-500 text-white shadow-lg shadow-fuchsia-500/30">
                <i data-lucide="play" class="h-5 w-5 fill-white"></i>
            </div>
        </div>
    </div>

    <div class="p-4">
        <p class="line-clamp-2 text-sm leading-6 text-slate-400">
            {{ $item['description'] }}
        </p>

        <div class="mt-4 flex items-center justify-between text-xs text-slate-400">
            <span>{{ $item['episodes'] }} episodes</span>
            <span>{{ $item['duration'] }}</span>
        </div>
    </div>
</div>