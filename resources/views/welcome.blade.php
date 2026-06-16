<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>FloxAnime — Watch Anime Online</title>

    <link rel="icon" href="{{ asset('logo/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { background: #070713; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Hero Carousel ── */
        .hero-slide { transition: opacity .7s ease; }

        /* ── Detail Bottom Sheet ── */
        #detailModal { opacity:0; pointer-events:none; transition:opacity .3s ease; }
        #detailModal.open { opacity:1; pointer-events:all; }
        #detailSheet {
            transform: translateY(100%);
            transition: transform .42s cubic-bezier(.32,.72,0,1);
            max-height: 92vh; overflow-y: auto;
        }
        #detailSheet::-webkit-scrollbar { display:none; }
        #detailModal.open #detailSheet { transform: translateY(0); }

        /* ── Netflix Player ── */
        #fullVideoModal { transition: opacity .25s ease; }
        #fullVideoModal.hidden { opacity:0; pointer-events:none; display:flex !important; }
        #fullVideoModal.visible { opacity:1; pointer-events:all; }
        #ytWrapper { position:relative; width:100%; height:100%; }
        #fullVideoFrame { position:absolute; inset:0; width:100%; height:100%; border:none; }

        /* Player overlays */
        #playerTopBar {
            background: linear-gradient(to bottom, rgba(0,0,0,.88) 0%, transparent 100%);
            transition: opacity .3s ease;
            padding-top: max(12px, env(safe-area-inset-top));
        }
        #playerBottomBar {
            background: linear-gradient(to top, rgba(0,0,0,.92) 0%, transparent 100%);
            transition: opacity .3s ease;
            padding-bottom: max(16px, env(safe-area-inset-bottom));
        }
        .ctrl-hidden { opacity:0 !important; pointer-events:none !important; }

        /* Progress bar */
        .prog-track { height:3px; background:rgba(255,255,255,.22); border-radius:99px; cursor:pointer; position:relative; }
        .prog-track:hover, .prog-track:active { height:5px; }
        .prog-fill { height:100%; background:linear-gradient(90deg,#a855f7,#ec4899); border-radius:99px; position:relative; transition:width .5s linear; }
        .prog-thumb { position:absolute; right:-7px; top:50%; transform:translateY(-50%) scale(0); width:14px; height:14px; background:#fff; border-radius:50%; box-shadow:0 0 10px rgba(168,85,247,.9); transition:transform .15s ease; }
        .prog-track:hover .prog-thumb, .prog-track:active .prog-thumb { transform:translateY(-50%) scale(1); }

        /* Center flash */
        #tapFlash { pointer-events:none; opacity:0; transition:opacity .15s ease; }
        #tapFlash.show { opacity:1; }

        /* Match badge */
        .match-badge { background: linear-gradient(90deg,#22c55e,#16a34a); }

        /* Tab active */
        .tab-btn { border-bottom:2px solid transparent; }
        .tab-btn.active { border-bottom-color:#a855f7; color:#fff; }

        /* Card hover */
        .v-card .card-overlay { opacity:0; transition:opacity .2s; }
        @media (hover:hover) { .v-card:hover .card-overlay { opacity:1; } }

        /* Dot carousel indicator */
        .hero-dot { transition: all .3s ease; }
        .hero-dot.active { width: 24px; background: #d946ef; }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeUp .35s ease both; }
    </style>
</head>

<body class="min-h-screen bg-[#070713] text-white">

@php
    $allItems = array_values(array_merge($trending, $latestEpisodes, $newUploads));
    $heroItem = $allItems[0] ?? null;
    $hasContent = count($allItems) > 0;
    $hasSliders = $sliders->count() > 0;
@endphp

{{-- ══ HEADER ═══════════════════════════════════════════════════════════════ --}}
<header class="sticky top-0 z-50 border-b border-white/10 bg-[#080812]/90 backdrop-blur-xl">
    <div class="flex items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <img src="{{ asset('logo/logo.png') }}" class="h-9 w-auto" alt="FloxAnime">

        <nav class="hidden items-center gap-5 text-sm text-slate-300 lg:flex">
            <button class="transition hover:text-white font-medium">Home</button>
            <button class="transition hover:text-white">Trending</button>
            <button class="transition hover:text-white">Latest</button>
            <button class="transition hover:text-white">New Uploads</button>
        </nav>

        <div class="ml-auto flex items-center gap-3">
            @if($hasContent)
                <button class="hidden rounded-full border border-white/10 bg-white/5 px-3 py-1.5
                               text-xs text-slate-300 hover:bg-white/10 sm:flex items-center gap-1.5">
                    <i data-lucide="search" class="h-3.5 w-3.5"></i>
                    Search
                </button>
            @endif
            <a href="{{ route('login') }}"
               class="rounded-xl bg-linear-to-r from-violet-500 to-fuchsia-500
                      px-4 py-2 text-xs font-bold text-white">
                Admin Login
            </a>
        </div>
    </div>
</header>

<main class="pb-24">

{{-- ══ HERO SECTION ══════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden">

    {{-- ── Case 1: Sliders from DB ── --}}
    @if($hasSliders)
        <div id="heroCarousel" class="relative h-[62vh] min-h-[430px] sm:h-[76vh]">

            @foreach($sliders as $idx => $slider)
                @php
                    $imgSrc = $slider->image_url
                        ?: ($slider->image_path ? Storage::url($slider->image_path) : null);
                @endphp
                <div class="hero-slide absolute inset-0 {{ $idx === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}"
                     data-slide="{{ $idx }}">

                    {{-- Background image --}}
                    @if($imgSrc)
                        <img src="{{ $imgSrc }}"
                             class="absolute inset-0 h-full w-full object-cover"
                             alt="{{ $slider->title }}">
                    @else
                        <div class="absolute inset-0 bg-linear-to-br from-violet-900/70 to-fuchsia-900/50"></div>
                    @endif

                    {{-- Gradient overlays --}}
                    <div class="absolute inset-0 bg-linear-to-t from-[#070713] via-[#070713]/60 to-black/20"></div>
                    <div class="absolute inset-0 bg-linear-to-r from-[#070713]/80 via-transparent to-transparent"></div>

                    {{-- Content --}}
                    <div class="absolute bottom-0 left-0 right-0 px-4 pb-12 sm:px-8 lg:px-12 lg:pb-16">
                        <div class="max-w-2xl fade-up">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-fuchsia-500
                                         px-3 py-1 text-[10px] font-black text-white">
                                <i data-lucide="zap" class="h-3 w-3 fill-white"></i>
                                Featured
                            </span>

                            <h1 class="mt-3 text-4xl font-black leading-tight sm:text-6xl drop-shadow-lg">
                                {{ $slider->title }}
                            </h1>

                            @if($slider->subtitle)
                                <p class="mt-2 text-base font-semibold text-slate-200 drop-shadow">
                                    {{ $slider->subtitle }}
                                </p>
                            @endif

                            @if($slider->description)
                                <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-400">
                                    {{ $slider->description }}
                                </p>
                            @endif

                            <div class="mt-5 flex flex-wrap gap-3">
                                @if($slider->button_link)
                                    <a href="{{ $slider->button_link }}"
                                       class="flex items-center gap-2 rounded-xl bg-white px-6 py-2.5
                                              text-sm font-black text-black shadow-lg active:scale-95 transition">
                                        <i data-lucide="play" class="h-4 w-4 fill-black"></i>
                                        {{ $slider->button_text ?? 'Watch Now' }}
                                    </a>
                                @elseif($hasContent)
                                    <button onclick="openFullVideo(0)"
                                            class="flex items-center gap-2 rounded-xl bg-white px-6 py-2.5
                                                   text-sm font-black text-black shadow-lg active:scale-95 transition">
                                        <i data-lucide="play" class="h-4 w-4 fill-black"></i>
                                        Play
                                    </button>
                                @endif

                                @if($hasContent)
                                    <button onclick="openDetailModal(0)"
                                            class="flex items-center gap-2 rounded-xl bg-white/20 px-5 py-2.5
                                                   text-sm font-bold text-white backdrop-blur active:scale-95 transition">
                                        <i data-lucide="info" class="h-4 w-4"></i>
                                        More Info
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Dot indicators --}}
            @if($sliders->count() > 1)
                <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 items-center gap-2">
                    @foreach($sliders as $idx => $_)
                        <button onclick="goSlide({{ $idx }}); resetAuto();"
                                class="hero-dot h-1.5 rounded-full {{ $idx === 0 ? 'active w-6 bg-fuchsia-400' : 'w-1.5 bg-white/30' }}">
                        </button>
                    @endforeach
                </div>

                {{-- Prev / Next --}}
                <button onclick="prevSlide()"
                        class="absolute left-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center
                               rounded-full bg-black/50 text-white backdrop-blur-sm
                               hover:bg-black/70 transition active:scale-90">
                    <i data-lucide="chevron-left" class="h-5 w-5"></i>
                </button>
                <button onclick="nextSlide()"
                        class="absolute right-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center
                               rounded-full bg-black/50 text-white backdrop-blur-sm
                               hover:bg-black/70 transition active:scale-90">
                    <i data-lucide="chevron-right" class="h-5 w-5"></i>
                </button>

                {{-- Slide counter --}}
                <div class="absolute right-4 top-4 z-10 rounded-full bg-black/50 px-3 py-1
                             text-[11px] font-bold text-white backdrop-blur-sm" id="slideCounter">
                    1 / {{ $sliders->count() }}
                </div>
            @endif
        </div>

    {{-- ── Case 2: No sliders — use first anime/episode as hero ── --}}
    @elseif($heroItem)
        <div class="relative h-[62vh] min-h-[430px] sm:h-[76vh]">
            <img src="{{ $heroItem['image'] }}"
                 class="absolute inset-0 h-full w-full object-cover"
                 alt="{{ $heroItem['title'] }}">

            <div class="absolute inset-0 bg-linear-to-t from-[#070713] via-[#070713]/75 to-black/30"></div>
            <div class="absolute inset-0 bg-linear-to-r from-[#070713]/85 via-transparent to-transparent"></div>

            <div class="absolute bottom-0 left-0 right-0 px-4 pb-8 sm:px-8 lg:px-12 lg:pb-16">
                <div class="max-w-2xl">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-fuchsia-500 px-3 py-1 text-[10px] font-black text-white">
                            #1 Featured
                        </span>
                        <span class="match-badge rounded px-1.5 py-0.5 text-[10px] font-black text-white">
                            {{ $heroItem['category'] }}
                        </span>
                    </div>

                    <h1 class="mt-3 text-4xl font-black leading-tight sm:text-6xl">
                        {{ $heroItem['title'] }}
                    </h1>

                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-300">
                        <span class="font-semibold">{{ $heroItem['year'] }}</span>
                        <span class="rounded border border-white/30 px-1 text-[10px]">HD</span>
                        <span>{{ $heroItem['episodes'] }} Eps</span>
                        <span>{{ $heroItem['duration'] }}</span>
                        <span class="font-bold text-yellow-400">★ {{ $heroItem['rating'] }}</span>
                    </div>

                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-300 sm:max-w-xl">
                        {{ $heroItem['description'] }}
                    </p>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <button onclick="openFullVideo(0)"
                                class="flex items-center gap-2 rounded-xl bg-white px-6 py-2.5
                                       text-sm font-black text-black shadow-lg active:scale-95 transition">
                            <i data-lucide="play" class="h-4 w-4 fill-black"></i>
                            Play
                        </button>
                        <button onclick="openDetailModal(0)"
                                class="flex items-center gap-2 rounded-xl bg-white/20 px-5 py-2.5
                                       text-sm font-bold text-white backdrop-blur active:scale-95 transition">
                            <i data-lucide="info" class="h-4 w-4"></i>
                            More Info
                        </button>
                    </div>
                </div>
            </div>
        </div>

    {{-- ── Case 3: Completely empty — invite admin to add content ── --}}
    @else
        <div class="flex h-[50vh] min-h-[360px] flex-col items-center justify-center px-4 text-center">
            <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-3xl
                        bg-linear-to-br from-violet-500/20 to-fuchsia-500/20
                        border border-violet-500/20">
                <i data-lucide="film" class="h-10 w-10 text-violet-400/60"></i>
            </div>
            <h2 class="text-2xl font-black text-white">No Content Yet</h2>
            <p class="mt-2 max-w-sm text-sm text-slate-500">
                The library is empty. Login as admin to start adding anime, episodes, and sliders.
            </p>
            <a href="{{ route('login') }}"
               class="mt-6 flex items-center gap-2 rounded-2xl bg-linear-to-r from-violet-500
                      to-fuchsia-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-500/25">
                <i data-lucide="shield" class="h-4 w-4"></i>
                Go to Admin
            </a>
        </div>
    @endif
</section>

{{-- ══ CONTENT ROWS ══════════════════════════════════════════════════════════ --}}

{{-- ── Trending Now ── --}}
@if(count($trending) > 0)
<section class="px-4 py-5 sm:px-6 lg:px-8">
    <div class="mb-3 flex items-center justify-between">
        <div>
            <h2 class="flex items-center gap-2 text-base font-black">
                <i data-lucide="trending-up" class="h-4 w-4 text-fuchsia-400"></i>
                Trending Now
            </h2>
            <p class="text-[11px] text-slate-500">Most watched anime today</p>
        </div>
        <span class="rounded-full bg-fuchsia-500/15 px-2.5 py-0.5 text-[10px] font-bold text-fuchsia-400">
            {{ count($trending) }}
        </span>
    </div>

    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($trending as $i => $item)
            @include('components.video-card-fixed', ['item' => $item, 'realIndex' => $i])
        @endforeach
    </div>
</section>
@endif

{{-- ── Latest Episodes ── --}}
@if(count($latestEpisodes) > 0)
<section class="px-4 py-5 sm:px-6 lg:px-8">
    <div class="mb-3 flex items-center justify-between">
        <div>
            <h2 class="flex items-center gap-2 text-base font-black">
                <i data-lucide="clock" class="h-4 w-4 text-yellow-400"></i>
                Latest Episodes
            </h2>
            <p class="text-[11px] text-slate-500">Recently aired episodes</p>
        </div>
        <span class="rounded-full bg-yellow-500/15 px-2.5 py-0.5 text-[10px] font-bold text-yellow-400">
            {{ count($latestEpisodes) }}
        </span>
    </div>

    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($latestEpisodes as $i => $item)
            @include('components.video-card-fixed', [
                'item'      => $item,
                'realIndex' => count($trending) + $i,
            ])
        @endforeach
    </div>
</section>
@endif

{{-- ── New Uploads ── --}}
@if(count($newUploads) > 0)
<section class="px-4 py-5 sm:px-6 lg:px-8">
    <div class="mb-3 flex items-center justify-between">
        <div>
            <h2 class="flex items-center gap-2 text-base font-black">
                <i data-lucide="upload-cloud" class="h-4 w-4 text-cyan-400"></i>
                New Uploads
            </h2>
            <p class="text-[11px] text-slate-500">Freshly added to the library</p>
        </div>
        <span class="rounded-full bg-cyan-500/15 px-2.5 py-0.5 text-[10px] font-bold text-cyan-400">
            {{ count($newUploads) }}
        </span>
    </div>

    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($newUploads as $i => $item)
            @include('components.video-card-fixed', [
                'item'      => $item,
                'realIndex' => count($trending) + count($latestEpisodes) + $i,
            ])
        @endforeach
    </div>
</section>
@endif

{{-- ── All-empty content message ── --}}
@if(!$hasContent)
<div class="flex flex-col items-center justify-center py-10 text-center text-slate-600">
    <i data-lucide="inbox" class="mb-3 h-10 w-10 opacity-30"></i>
    <p class="text-sm">No videos in the library yet.</p>
</div>
@endif

</main>

{{-- ══ MOBILE BOTTOM NAV ══════════════════════════════════════════════════════ --}}
<nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-white/10 bg-[#080812]/95 backdrop-blur-xl lg:hidden">
    <div class="flex items-center justify-around px-2 pt-2"
         style="padding-bottom:max(8px,env(safe-area-inset-bottom));">
        <button class="flex flex-col items-center gap-0.5 px-4 py-1 text-fuchsia-400">
            <i data-lucide="home" class="h-5 w-5"></i>
            <span class="text-[10px] font-semibold">Home</span>
        </button>
        <button class="flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500">
            <i data-lucide="search" class="h-5 w-5"></i>
            <span class="text-[10px]">Search</span>
        </button>
        <button class="flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500">
            <i data-lucide="compass" class="h-5 w-5"></i>
            <span class="text-[10px]">Genres</span>
        </button>
        <a href="{{ route('login') }}" class="flex flex-col items-center gap-0.5 px-4 py-1 text-slate-500">
            <i data-lucide="user" class="h-5 w-5"></i>
            <span class="text-[10px]">Admin</span>
        </a>
    </div>
</nav>

{{-- ══ DETAIL BOTTOM SHEET ════════════════════════════════════════════════════ --}}
<div id="detailModal"
     class="fixed inset-0 z-130 flex items-end justify-center"
     style="background:rgba(0,0,0,.75);"
     onclick="detailBackdrop(event)">

    <div id="detailSheet" class="w-full max-w-lg overflow-hidden rounded-t-3xl bg-[#111122] shadow-2xl sm:max-w-xl">

        <div class="flex justify-center pt-3 pb-1">
            <div class="h-1 w-10 rounded-full bg-white/25"></div>
        </div>

        <div class="relative aspect-video bg-black">
            <img id="detailImage" src="" class="h-full w-full object-cover" alt="">
            <div class="absolute inset-0 bg-linear-to-t from-[#111122] via-black/30 to-transparent"></div>

            <button onclick="closeDetailModal()"
                    class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-[#111122]/80 backdrop-blur">
                <i data-lucide="x" class="h-4 w-4 text-white"></i>
            </button>

            <div class="absolute inset-0 flex items-center justify-center">
                <button id="detailPlayCenter"
                        class="flex h-16 w-16 items-center justify-center rounded-full
                               bg-white/20 backdrop-blur-sm ring-2 ring-white/30 transition active:scale-90">
                    <i data-lucide="play" class="h-8 w-8 fill-white text-white"></i>
                </button>
            </div>

            <div class="absolute bottom-3 left-3 flex flex-wrap items-center gap-1.5">
                <span id="detailCatBadge" class="rounded-full bg-fuchsia-500 px-2.5 py-0.5 text-[9px] font-black text-white"></span>
                <span class="match-badge rounded px-1.5 py-0.5 text-[9px] font-black text-white">HD</span>
            </div>
        </div>

        <div class="flex items-center gap-3 px-4 py-3">
            <button id="detailPlayBtn"
                    class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-white
                           py-2.5 text-sm font-black text-black transition active:scale-95">
                <i data-lucide="play" class="h-4 w-4 fill-black"></i>
                Play
            </button>
            <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/25 bg-white/10">
                <i data-lucide="plus" class="h-4 w-4"></i>
            </button>
            <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/25 bg-white/10">
                <i data-lucide="thumbs-up" class="h-4 w-4"></i>
            </button>
            <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/25 bg-white/10">
                <i data-lucide="share-2" class="h-4 w-4"></i>
            </button>
        </div>

        <div class="flex flex-wrap items-center gap-2 px-4 pb-2 text-xs text-slate-400">
            <span id="detailYear" class="font-semibold text-white"></span>
            <span class="rounded border border-white/20 px-1 text-[10px] text-slate-300">HD</span>
            <span id="detailEps" class="text-slate-400"></span>
            <span>•</span>
            <span id="detailDur" class="text-slate-400"></span>
            <span class="ml-auto font-bold text-yellow-400" id="detailRating"></span>
        </div>

        <div class="px-4 pb-3">
            <h2 id="detailTitle" class="text-xl font-black text-white"></h2>
            <p id="detailStudio" class="mt-0.5 text-[11px] text-slate-500"></p>
            <p id="detailDescription" class="mt-2 text-sm leading-6 text-slate-300"></p>
        </div>

        <div class="border-t border-white/10 px-4">
            <div class="flex gap-6 text-sm">
                <button class="tab-btn active py-3 font-semibold text-white">Episodes</button>
                <button class="tab-btn py-3 font-semibold text-slate-400">Similar</button>
                <button class="tab-btn py-3 font-semibold text-slate-400">About</button>
            </div>
        </div>

        <div id="detailEpisodeList" class="px-4 pb-6 pt-1 space-y-0.5"></div>
    </div>
</div>

{{-- ══ FULLSCREEN PLAYER ══════════════════════════════════════════════════════ --}}
<div id="fullVideoModal"
     class="fixed inset-0 z-150 hidden flex-col items-center justify-center bg-black">

    <div id="ytWrapper" class="relative h-full w-full">
        <iframe id="fullVideoFrame" src="" title="Video Player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>

        <div id="tapZone" class="absolute inset-0 z-10" onclick="toggleControls()"
             style="background:transparent;"></div>

        <div id="tapFlash"
             class="pointer-events-none absolute left-1/2 top-1/2 z-20 flex -translate-x-1/2
                    -translate-y-1/2 h-20 w-20 items-center justify-center rounded-full
                    bg-black/50 backdrop-blur-sm">
            <i id="tapFlashIcon" data-lucide="play" class="h-9 w-9 fill-white text-white"></i>
        </div>

        <div id="playerTopBar"
             class="absolute left-0 right-0 top-0 z-30 flex items-center gap-3 px-4 pb-8 pt-3">
            <button onclick="closeFullVideo()"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-black/40 backdrop-blur-sm transition active:scale-90">
                <i data-lucide="arrow-left" class="h-5 w-5 text-white"></i>
            </button>
            <div class="flex-1 min-w-0">
                <p id="playerTitle" class="truncate text-sm font-black text-white leading-tight"></p>
                <p id="playerMeta" class="truncate text-[11px] text-slate-300"></p>
            </div>
            <button class="flex h-9 w-9 items-center justify-center rounded-full bg-black/40 backdrop-blur-sm">
                <i data-lucide="cast" class="h-4 w-4 text-white"></i>
            </button>
            <button class="flex h-9 w-9 items-center justify-center rounded-full bg-black/40 backdrop-blur-sm">
                <i data-lucide="settings" class="h-4 w-4 text-white"></i>
            </button>
        </div>

        <div id="playerBottomBar" class="absolute bottom-0 left-0 right-0 z-30 px-4 pb-4 pt-10">
            <div class="mb-3 flex items-center gap-3">
                <span id="timeCurrent" class="w-10 shrink-0 text-right text-[11px] font-semibold text-white tabular-nums">0:00</span>
                <div class="prog-track flex-1" id="progressBar" onclick="seekVideo(event)">
                    <div id="progressFill" class="prog-fill" style="width:0%">
                        <div class="prog-thumb"></div>
                    </div>
                </div>
                <span id="timeDuration" class="w-10 shrink-0 text-[11px] font-semibold text-slate-400 tabular-nums">0:00</span>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="skipBack()" class="transition active:scale-90">
                    <i data-lucide="skip-back" class="h-5 w-5 text-white"></i>
                </button>
                <button id="playPauseBtn" onclick="togglePlayPause()"
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-white shadow-lg shadow-white/20 transition active:scale-90">
                    <i data-lucide="pause" class="h-6 w-6 fill-black text-black"></i>
                </button>
                <button onclick="skipForward()" class="transition active:scale-90">
                    <i data-lucide="skip-forward" class="h-5 w-5 text-white"></i>
                </button>
                <div class="flex-1"></div>
                <button id="muteBtn" onclick="toggleMute()" class="transition active:scale-90">
                    <i data-lucide="volume-2" class="h-5 w-5 text-white"></i>
                </button>
                <button onclick="requestFullscreen()" class="transition active:scale-90">
                    <i data-lucide="maximize" class="h-5 w-5 text-white"></i>
                </button>
            </div>
        </div>

        <div id="playerEpChips"
             class="absolute bottom-28 left-0 right-0 z-30 flex gap-2 overflow-x-auto px-4 pb-1 scrollbar-hide">
        </div>
    </div>
</div>

<script src="https://www.youtube.com/iframe_api"></script>

<script>
/* ════════════════════════════════════
   DATA from DB
════════════════════════════════════ */
const animeData = @json($allItems);

/* ════════════════════════════════════
   HERO CAROUSEL
════════════════════════════════════ */
@if($hasSliders && $sliders->count() > 1)
const slides    = document.querySelectorAll('.hero-slide');
const dots      = document.querySelectorAll('.hero-dot');
const counter   = document.getElementById('slideCounter');
let curSlide    = 0;
let autoTimer;

function goSlide(n) {
    slides[curSlide].classList.add('opacity-0','pointer-events-none');
    slides[curSlide].classList.remove('opacity-100');
    dots[curSlide].classList.remove('active','bg-fuchsia-400','w-6');
    dots[curSlide].classList.add('bg-white/30','w-1.5');

    curSlide = (n + slides.length) % slides.length;

    slides[curSlide].classList.remove('opacity-0','pointer-events-none');
    slides[curSlide].classList.add('opacity-100');
    dots[curSlide].classList.add('active','bg-fuchsia-400','w-6');
    dots[curSlide].classList.remove('bg-white/30','w-1.5');

    if (counter) counter.textContent = (curSlide + 1) + ' / ' + slides.length;
}

function nextSlide() { goSlide(curSlide + 1); }
function prevSlide()  { goSlide(curSlide - 1); }
function resetAuto()  { clearInterval(autoTimer); autoTimer = setInterval(nextSlide, 5000); }
resetAuto();
@endif

/* ════════════════════════════════════
   LUCIDE ICONS
════════════════════════════════════ */
function refreshIcons() { lucide.createIcons(); }

/* ════════════════════════════════════
   DETAIL MODAL
════════════════════════════════════ */
function openDetailModal(index) {
    const item = animeData[index];
    if (!item) return;

    document.getElementById('detailImage').src            = item.image;
    document.getElementById('detailCatBadge').innerText   = item.category;
    document.getElementById('detailYear').innerText       = item.year;
    document.getElementById('detailRating').innerText     = '★ ' + item.rating;
    document.getElementById('detailTitle').innerText      = item.title;
    document.getElementById('detailStudio').innerText     = (item.studio || '') + (item.director ? ' · Dir. ' + item.director : '');
    document.getElementById('detailEps').innerText        = (item.episodes || '0') + ' Episodes';
    document.getElementById('detailDur').innerText        = item.duration || '24 min';
    document.getElementById('detailDescription').innerText = item.description || '';

    const epN = Math.min(parseInt(item.episodes) || 1, 4);
    let epHtml = '';
    for (let i = 1; i <= epN; i++) {
        epHtml += `<div class="flex items-center gap-3 rounded-xl py-2.5 px-1 hover:bg-white/5 cursor-pointer transition"
                        onclick="closeDetailModal(); openFullVideo(${index})">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/10 text-sm font-black text-white">${i}</div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-white">Episode ${i}</p>
                <p class="text-[11px] text-slate-400">${item.duration || '24 min'}</p>
            </div>
            <i data-lucide="play" class="h-4 w-4 shrink-0 text-slate-400 fill-slate-400"></i>
        </div>`;
    }
    document.getElementById('detailEpisodeList').innerHTML = epHtml;

    const onPlay = () => { closeDetailModal(); openFullVideo(index); };
    document.getElementById('detailPlayBtn').onclick    = onPlay;
    document.getElementById('detailPlayCenter').onclick = onPlay;

    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    requestAnimationFrame(() => modal.classList.add('open'));
    document.body.style.overflow = 'hidden';
    refreshIcons();
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.remove('open');
    setTimeout(() => modal.classList.add('hidden'), 420);
    document.body.style.overflow = '';
}

function detailBackdrop(e) {
    if (e.target === document.getElementById('detailModal')) closeDetailModal();
}

/* ════════════════════════════════════
   YOUTUBE PLAYER
════════════════════════════════════ */
let ytPlayer    = null;
let ytReady     = false;
let isPlaying   = true;
let isMuted     = false;
let progressInt = null;
let ctrlTimer   = null;
let ctrlVisible = true;

window.onYouTubeIframeAPIReady = () => { ytReady = true; };

function openFullVideo(index) {
    const item = animeData[index];
    if (!item || !item.video_url) {
        alert('No video URL available for this item.');
        return;
    }

    document.getElementById('playerTitle').innerText = item.title;
    document.getElementById('playerMeta').innerText  = 'EP ' + (item.episode_number || 1) + ' · ' + (item.duration || '24 min');

    const chipsEl = document.getElementById('playerEpChips');
    chipsEl.innerHTML = '';
    const epN = Math.min(parseInt(item.episodes) || 1, 6);
    for (let i = 1; i <= epN; i++) {
        chipsEl.innerHTML += `<button class="shrink-0 rounded-lg ${i===1?'bg-fuchsia-500 text-white font-black':'bg-white/10 text-slate-300'} px-3 py-1 text-xs font-semibold">EP ${i}</button>`;
    }

    const modal = document.getElementById('fullVideoModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    isPlaying = true;

    if (item.video_id && ytReady) {
        if (ytPlayer) {
            ytPlayer.loadVideoById(item.video_id);
        } else {
            ytPlayer = new YT.Player('fullVideoFrame', {
                videoId: item.video_id,
                playerVars: { autoplay:1, rel:0, modestbranding:1, iv_load_policy:3 },
                events: {
                    onReady: e => { e.target.playVideo(); startProgress(); },
                    onStateChange: e => {
                        isPlaying = (e.data === YT.PlayerState.PLAYING);
                        updatePlayBtn();
                        isPlaying ? startProgress() : stopProgress();
                    },
                },
            });
        }
    } else {
        document.getElementById('fullVideoFrame').src = item.video_url + (item.video_url.includes('?') ? '&' : '?') + 'autoplay=1&rel=0';
    }

    showControls();
    refreshIcons();
}

function closeFullVideo() {
    stopProgress(); clearTimeout(ctrlTimer);
    if (ytPlayer && ytPlayer.stopVideo) ytPlayer.stopVideo();
    else document.getElementById('fullVideoFrame').src = '';

    const modal = document.getElementById('fullVideoModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    document.getElementById('progressFill').style.width = '0%';
    document.getElementById('timeCurrent').innerText   = '0:00';
    document.getElementById('timeDuration').innerText  = '0:00';
}

function showControls() {
    ctrlVisible = true;
    ['playerTopBar','playerBottomBar','playerEpChips'].forEach(id =>
        document.getElementById(id)?.classList.remove('ctrl-hidden'));
    clearTimeout(ctrlTimer);
    ctrlTimer = setTimeout(hideControls, 3500);
}
function hideControls() {
    ctrlVisible = false;
    ['playerTopBar','playerBottomBar','playerEpChips'].forEach(id =>
        document.getElementById(id)?.classList.add('ctrl-hidden'));
}
function toggleControls() { ctrlVisible ? hideControls() : showControls(); }

function togglePlayPause() {
    if (!ytPlayer?.getPlayerState) return;
    isPlaying ? ytPlayer.pauseVideo() : ytPlayer.playVideo();
    showFlash(); showControls();
}
function showFlash() {
    document.getElementById('tapFlashIcon').setAttribute('data-lucide', isPlaying ? 'pause' : 'play');
    refreshIcons();
    const f = document.getElementById('tapFlash');
    f.classList.add('show');
    setTimeout(() => f.classList.remove('show'), 600);
}
function updatePlayBtn() {
    const btn = document.getElementById('playPauseBtn');
    if (!btn) return;
    btn.innerHTML = isPlaying
        ? '<i data-lucide="pause" class="h-6 w-6 fill-black text-black"></i>'
        : '<i data-lucide="play"  class="h-6 w-6 fill-black text-black"></i>';
    refreshIcons();
}

function skipBack()    { if (ytPlayer?.getCurrentTime) { ytPlayer.seekTo(Math.max(0, ytPlayer.getCurrentTime()-10), true); showControls(); } }
function skipForward() { if (ytPlayer?.getCurrentTime) { ytPlayer.seekTo(ytPlayer.getCurrentTime()+10, true); showControls(); } }

function toggleMute() {
    if (!ytPlayer) return;
    isMuted ? ytPlayer.unMute() : ytPlayer.mute();
    isMuted = !isMuted;
    document.getElementById('muteBtn').innerHTML = isMuted
        ? '<i data-lucide="volume-x" class="h-5 w-5 text-white"></i>'
        : '<i data-lucide="volume-2" class="h-5 w-5 text-white"></i>';
    refreshIcons(); showControls();
}

function requestFullscreen() {
    const el = document.getElementById('fullVideoModal');
    (el.requestFullscreen || el.webkitRequestFullscreen || function(){}).call(el);
    showControls();
}

function seekVideo(e) {
    if (!ytPlayer?.getDuration) return;
    const rect = document.getElementById('progressBar').getBoundingClientRect();
    const pct  = Math.min(1, Math.max(0, (e.clientX - rect.left) / rect.width));
    ytPlayer.seekTo(pct * ytPlayer.getDuration(), true);
    showControls();
}

function startProgress() { stopProgress(); progressInt = setInterval(updateProgress, 500); }
function stopProgress()  { clearInterval(progressInt); }
function updateProgress() {
    if (!ytPlayer?.getCurrentTime) return;
    const cur = ytPlayer.getCurrentTime() || 0;
    const dur = ytPlayer.getDuration()    || 0;
    if (dur > 0) document.getElementById('progressFill').style.width = ((cur/dur)*100) + '%';
    document.getElementById('timeCurrent').innerText  = fmtTime(cur);
    document.getElementById('timeDuration').innerText = fmtTime(dur);
}
function fmtTime(s) {
    const m = Math.floor(s/60);
    return m + ':' + String(Math.floor(s%60)).padStart(2,'0');
}

/* ── Keyboard ── */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape')       { closeFullVideo(); closeDetailModal(); }
    if (e.key === ' ')            { e.preventDefault(); togglePlayPause(); }
    if (e.key === 'ArrowLeft')    skipBack();
    if (e.key === 'ArrowRight')   skipForward();
});

/* ── Tab switching ── */
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

refreshIcons();
</script>

</body>
</html>
