<section id="heroSliderContainer"
         class="relative w-full overflow-hidden"
         style="height:78vh;min-height:460px;max-height:740px;">

    {{-- ── Background slides ────────────────────────────────────────── --}}
    @foreach($animeList as $index => $item)
    <div class="hero-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
         data-index="{{ $index }}">
        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
             class="h-full w-full object-cover object-center">

        {{-- Top fade for nav readability --}}
        <div class="absolute inset-0 bg-linear-to-b from-black/70 via-transparent to-transparent" style="height:35%"></div>
        {{-- Bottom fade for content readability --}}
        <div class="absolute bottom-0 left-0 right-0 bg-linear-to-t from-[#070713] via-[#070713]/80 to-transparent" style="height:75%"></div>
        {{-- Side vignette --}}
        <div class="absolute inset-0 bg-linear-to-r from-[#070713]/50 via-transparent to-transparent"></div>
    </div>
    @endforeach

    {{-- ── Slide content ────────────────────────────────────────────── --}}
    @foreach($animeList as $index => $item)
    <div class="hero-content absolute bottom-0 left-0 right-0 px-4 pb-10 sm:px-6 sm:pb-12 lg:px-10 lg:pb-14 {{ $index === 0 ? 'block' : 'hidden' }}"
         data-index="{{ $index }}">

        {{-- Badges --}}
        <div class="mb-3 flex flex-wrap items-center gap-2">
            <span class="rounded-full bg-fuchsia-500 px-3 py-1 text-[11px] font-bold text-white">
                {{ $item['category'] }}
            </span>
            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[11px] text-white backdrop-blur-sm">
                {{ $item['year'] }}
            </span>
            <span class="flex items-center gap-1 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[11px] text-yellow-400 backdrop-blur-sm">
                <i data-lucide="star" class="h-3 w-3 fill-yellow-400 text-yellow-400"></i>
                {{ $item['rating'] }}/10
            </span>
        </div>

        {{-- Title --}}
        <h2 class="text-3xl font-black leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl xl:text-6xl">
            {{ $item['title'] }}
        </h2>

        {{-- Meta --}}
        <p class="mt-1.5 text-xs text-slate-400 sm:text-sm">
            {{ $item['episodes'] }} Episodes &middot; {{ $item['duration'] }} &middot; {{ $item['studio'] }}
        </p>

        {{-- Description --}}
        <p class="mt-2 line-clamp-2 max-w-lg text-xs leading-5 text-slate-300 sm:text-sm sm:leading-relaxed">
            {{ $item['description'] }}
        </p>

        {{-- Action buttons --}}
        <div class="mt-4 flex flex-wrap gap-2 sm:gap-3">
            <button onclick="openVideoPlayer({{ $index }})"
                    class="flex h-10 items-center gap-2 rounded-xl bg-linear-to-r from-violet-500 to-fuchsia-500 px-5 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/25 hover:opacity-90 active:scale-95 transition sm:h-11 sm:px-7">
                <i data-lucide="play" class="h-4 w-4 fill-white"></i>
                Play Now
            </button>
            <button onclick="openConfirmModal()"
                    class="flex h-10 items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-5 text-sm font-bold text-white backdrop-blur-sm hover:bg-white/20 active:scale-95 transition sm:h-11 sm:px-6">
                <i data-lucide="plus" class="h-4 w-4"></i>
                My List
            </button>
            <button onclick="openAnimeDetail({{ $index }})"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/20 bg-white/10 text-white backdrop-blur-sm hover:bg-white/20 active:scale-95 transition sm:h-11 sm:w-auto sm:px-5 sm:gap-2">
                <i data-lucide="info" class="h-4 w-4"></i>
                <span class="hidden sm:inline text-sm font-bold">More Info</span>
            </button>
        </div>
    </div>
    @endforeach

    {{-- ── Slide dots (bottom right) ────────────────────────────────── --}}
    <div class="absolute bottom-4 right-4 z-10 flex items-center gap-1.5 sm:bottom-6 sm:right-6">
        @foreach($animeList as $index => $item)
            <button type="button"
                    onclick="setSlide({{ $index }})"
                    class="hero-dot rounded-full transition-all {{ $index === 0 ? 'h-1.5 w-5 bg-fuchsia-400' : 'h-1.5 w-1.5 bg-white/30 hover:bg-white/60' }}"
                    data-index="{{ $index }}">
            </button>
        @endforeach
    </div>

    {{-- ── Prev / Next arrows (desktop) ────────────────────────────── --}}
    <button type="button" onclick="prevSlide()"
            class="absolute left-3 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/15 bg-black/50 text-white backdrop-blur-sm transition hover:bg-black/70 md:flex">
        <i data-lucide="chevron-left" class="h-5 w-5"></i>
    </button>
    <button type="button" onclick="nextSlide()"
            class="absolute right-3 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/15 bg-black/50 text-white backdrop-blur-sm transition hover:bg-black/70 md:flex">
        <i data-lucide="chevron-right" class="h-5 w-5"></i>
    </button>

</section>
