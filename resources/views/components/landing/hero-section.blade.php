<section class="w-full">
    <div class="relative min-h-[620px] w-full overflow-hidden bg-[#070713]">

        @foreach($animeList as $index => $item)
            <div
                class="hero-slide absolute inset-0 bg-cover bg-center transition-all duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                style="background-image: url('{{ $item['image'] }}')"
                data-index="{{ $index }}"
            ></div>
        @endforeach

        <div class="absolute inset-0 bg-gradient-to-r from-[#070713] via-[#070713]/85 to-[#070713]/20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#070713] via-transparent to-[#070713]/30"></div>

        <div class="relative z-10 mx-auto grid min-h-[620px] max-w-7xl items-center gap-10 px-4 py-10 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="max-w-3xl">
                @foreach($animeList as $index => $item)
                    <div class="hero-content {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}">
                        <div class="mb-5 flex flex-wrap items-center gap-3">
                            <span class="rounded-full bg-fuchsia-500 px-4 py-1.5 text-sm font-semibold text-white">
                                Featured Anime
                            </span>

                            <span class="rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm text-white backdrop-blur">
                                {{ $item['year'] }}
                            </span>

                            <span class="rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm text-white backdrop-blur">
                                {{ $item['category'] }}
                            </span>
                        </div>

                        <h2 class="text-4xl font-black leading-tight tracking-tight text-white sm:text-6xl lg:text-7xl">
                            {{ $item['title'] }}
                        </h2>

                        <div class="mt-5 flex flex-wrap items-center gap-4 text-sm text-slate-300">
                            <span class="flex items-center gap-2">
                                <i data-lucide="star" class="h-5 w-5 fill-yellow-400 text-yellow-400"></i>
                                {{ $item['rating'] }}/10
                            </span>

                            <span>{{ $item['votes'] }} votes</span>
                            <span>{{ $item['episodes'] }} episodes</span>
                            <span>{{ $item['duration'] }}</span>
                        </div>

                        <p class="mt-6 max-w-2xl text-base leading-7 text-slate-300 sm:text-lg">
                            {{ $item['description'] }}
                        </p>

                        <div class="mt-8 flex flex-wrap gap-4">
                            <button class="flex h-12 items-center rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-7 text-base font-bold text-white shadow-lg shadow-fuchsia-500/25 hover:opacity-90">
                                <i data-lucide="play" class="mr-2 h-5 w-5 fill-white"></i>
                                Play Now
                            </button>

                            <button onclick="openConfirmModal()" class="flex h-12 items-center rounded-2xl border border-white/15 bg-white/10 px-7 text-base font-bold text-white backdrop-blur hover:bg-white/15">
                                <i data-lucide="bookmark" class="mr-2 h-5 w-5"></i>
                                My List
                            </button>

                            <button onclick="openAnimeDetail({{ $index }})" class="flex h-12 items-center rounded-2xl border border-white/15 bg-white/10 px-7 text-base font-bold text-white backdrop-blur hover:bg-white/15">
                                <i data-lucide="info" class="mr-2 h-5 w-5"></i>
                                Info
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="hidden justify-end lg:flex">
                @foreach($animeList as $index => $item)
                    <div class="hero-poster relative {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}">
                        <div class="absolute -inset-4 rounded-[2.5rem] bg-fuchsia-500/20 blur-2xl"></div>
                        <img
                            src="{{ $item['image'] }}"
                            alt="{{ $item['title'] }}"
                            class="relative h-[470px] w-[330px] rounded-[2rem] object-cover shadow-2xl transition-all duration-700"
                        />
                    </div>
                @endforeach
            </div>
        </div>

        <button
            type="button"
            onclick="prevSlide()"
            class="absolute left-4 top-1/2 z-20 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/10 bg-black/40 text-white backdrop-blur transition hover:bg-black/70 md:flex"
        >
            <i data-lucide="chevron-left" class="h-6 w-6"></i>
        </button>

        <button
            type="button"
            onclick="nextSlide()"
            class="absolute right-4 top-1/2 z-20 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/10 bg-black/40 text-white backdrop-blur transition hover:bg-black/70 md:flex"
        >
            <i data-lucide="chevron-right" class="h-6 w-6"></i>
        </button>

        <div class="absolute bottom-8 left-1/2 z-20 flex -translate-x-1/2 items-center gap-2">
            @foreach($animeList as $index => $item)
                <button
                    type="button"
                    onclick="setSlide({{ $index }})"
                    class="hero-dot h-2 rounded-full transition-all {{ $index === 0 ? 'w-9 bg-fuchsia-400' : 'w-2 bg-white/40 hover:bg-white/70' }}"
                    data-index="{{ $index }}"
                ></button>
            @endforeach
        </div>
    </div>
</section>