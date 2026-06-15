<section id="heroSliderContainer"
         class="relative w-full overflow-hidden">
    <style>
        /* mobile — compact */
        #heroSliderContainer { height: 50vw; min-height: 220px; max-height: 340px; }
        /* tablet */
        @media (min-width: 640px) {
            #heroSliderContainer { height: 62vh; min-height: 360px; max-height: 560px; }
        }
        /* desktop */
        @media (min-width: 1024px) {
            #heroSliderContainer { height: 78vh; min-height: 460px; max-height: 740px; }
        }
    </style>

    {{-- ── Background slides ────────────────────────────────────────── --}}
    @foreach($animeList as $index => $item)
    <div class="hero-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
         data-index="{{ $index }}">
        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
             class="h-full w-full object-cover object-center">

        {{-- Top fade --}}
        <div class="absolute top-0 left-0 right-0 h-20 bg-linear-to-b from-black/60 to-transparent"></div>
        {{-- Bottom fade --}}
        <div class="absolute bottom-0 left-0 right-0 bg-linear-to-t from-[#070713] via-[#070713]/75 to-transparent" style="height:70%"></div>
        {{-- Left vignette --}}
        <div class="absolute inset-0 bg-linear-to-r from-[#070713]/40 via-transparent to-transparent"></div>
    </div>
    @endforeach

    {{-- ── Slide content ────────────────────────────────────────────── --}}
    @foreach($animeList as $index => $item)
    <div class="hero-content absolute bottom-0 left-0 right-0 px-3 pb-4 sm:px-6 sm:pb-9 lg:px-10 lg:pb-14 {{ $index === 0 ? 'block' : 'hidden' }}"
         data-index="{{ $index }}">

        {{-- Badges — visible sm+ only --}}
        <div class="mb-1.5 hidden flex-wrap items-center gap-1.5 sm:flex sm:mb-3 sm:gap-2">
            <span class="rounded-full bg-fuchsia-500 px-2.5 py-0.5 text-[10px] font-bold text-white">
                {{ $item['category'] }}
            </span>
            <span class="rounded-full border border-white/20 bg-white/10 px-2.5 py-0.5 text-[10px] text-white backdrop-blur-sm">
                {{ $item['year'] }}
            </span>
            <span class="flex items-center gap-1 rounded-full border border-white/20 bg-white/10 px-2.5 py-0.5 text-[10px] text-yellow-400 backdrop-blur-sm">
                <i data-lucide="star" class="h-2.5 w-2.5 fill-yellow-400 text-yellow-400"></i>
                {{ $item['rating'] }}/10
            </span>
        </div>

        {{-- Mobile category chip --}}
        <span class="mb-1.5 inline-block rounded-md bg-fuchsia-500/90 px-2 py-0.5 text-[9px] font-bold text-white sm:hidden">
            {{ $item['category'] }}
        </span>

        {{-- Title --}}
        <h2 class="text-base font-black leading-tight tracking-tight text-white
                   sm:text-3xl lg:text-5xl xl:text-6xl">
            {{ $item['title'] }}
        </h2>

        {{-- Meta — sm+ only --}}
        <p class="mt-1 hidden text-xs text-slate-400 sm:block sm:mt-1.5 sm:text-sm">
            {{ $item['episodes'] }} Eps &middot; {{ $item['duration'] }} &middot; {{ $item['studio'] }}
        </p>

        {{-- Description — sm+ only --}}
        <p class="mt-1.5 hidden line-clamp-2 max-w-lg text-xs leading-5 text-slate-300 sm:block sm:text-sm sm:leading-relaxed">
            {{ $item['description'] }}
        </p>

        {{-- Action buttons --}}
        <div class="mt-2.5 flex items-center gap-2 sm:mt-4 sm:gap-3">
            <button onclick="openVideoPlayer({{ $index }})"
                    class="flex h-7 items-center gap-1.5 rounded-lg bg-linear-to-r from-violet-500 to-fuchsia-500 px-3 text-[11px] font-bold text-white shadow-md shadow-fuchsia-500/25 hover:opacity-90 active:scale-95 transition
                           sm:h-10 sm:rounded-xl sm:px-5 sm:text-sm">
                <i data-lucide="play" class="h-3 w-3 fill-white sm:h-4 sm:w-4"></i>
                Play
            </button>
            <button onclick="openConfirmModal()"
                    class="flex h-7 items-center gap-1.5 rounded-lg border border-white/25 bg-white/10 px-3 text-[11px] font-bold text-white backdrop-blur-sm hover:bg-white/20 active:scale-95 transition
                           sm:h-10 sm:rounded-xl sm:px-5 sm:text-sm">
                <i data-lucide="plus" class="h-3 w-3 sm:h-4 sm:w-4"></i>
                <span>List</span>
            </button>
            <button onclick="openAnimeDetail({{ $index }})"
                    class="flex h-7 w-7 items-center justify-center rounded-lg border border-white/25 bg-white/10 text-white backdrop-blur-sm hover:bg-white/20 active:scale-95 transition
                           sm:h-10 sm:w-auto sm:rounded-xl sm:gap-2 sm:px-5">
                <i data-lucide="info" class="h-3 w-3 sm:h-4 sm:w-4"></i>
                <span class="hidden sm:inline text-sm font-bold">Info</span>
            </button>
        </div>
    </div>
    @endforeach

    {{-- ── Slide dots ───────────────────────────────────────────────── --}}
    <div class="absolute bottom-2 right-3 z-10 flex items-center gap-1 sm:bottom-5 sm:right-5 sm:gap-1.5">
        @foreach($animeList as $index => $item)
            <button type="button"
                    onclick="setSlide({{ $index }})"
                    class="hero-dot rounded-full transition-all {{ $index === 0 ? 'h-1 w-4 bg-fuchsia-400 sm:h-1.5 sm:w-5' : 'h-1 w-1 bg-white/30 hover:bg-white/60 sm:h-1.5 sm:w-1.5' }}"
                    data-index="{{ $index }}">
            </button>
        @endforeach
    </div>

    {{-- ── Prev / Next arrows (md+ desktop only) ───────────────────── --}}
    <button type="button" onclick="prevSlide()"
            class="absolute left-3 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-white/15 bg-black/50 text-white backdrop-blur-sm transition hover:bg-black/70 md:flex">
        <i data-lucide="chevron-left" class="h-5 w-5"></i>
    </button>
    <button type="button" onclick="nextSlide()"
            class="absolute right-3 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-white/15 bg-black/50 text-white backdrop-blur-sm transition hover:bg-black/70 md:flex">
        <i data-lucide="chevron-right" class="h-5 w-5"></i>
    </button>

</section>
